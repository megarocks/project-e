<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "distributors".
     *
     * @property integer $id
     * @property integer $user_id
     * @property string $title
     * @property int $country_id;
     * @property string $created_at
     * @property string $updated_at
     * @property string $countryName;
     *
     * @property string $email
     *
     * @property DistributorCountry[] $distributorsCountries
     * @property Country[] $countries
     * @property PurchaseOrder[] $purchaseOrders
     * @property EndUser[] $endUsers
     * @property System[] $systems
     */
    class Distributor extends \yii\db\ActiveRecord implements PpdModelInterface
    {
        public $country_id; //temp  country id storage

        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'distributors';
        }

        public function behaviors()
        {
            return [
                'dateTimeStampBehavior' => [
                    'class'      => DateTimeStampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                    ]
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['user_id', 'title', 'country_id', 'email'], 'required'],
                [['title'], 'string', 'max' => 128],
                [['email'], 'email'],
                [['email'], 'unique'],
                [['country_id', 'created_at', 'updated_at', 'user_id', 'title'], 'safe']
            ];
        }

        /**
         * @inheritdoccountr
         */
        public function attributeLabels()
        {
            return [
                'id'          => 'ID',
                'title'       => Yii::t('app', 'Title'),
                'email'       => Yii::t('app', 'Email'),
                'created_at'  => Yii::t('app', 'Created At'),
                'updated_at'  => Yii::t('app', 'Updated At'),
                'country_id'  => Yii::t('app', 'Country'),
                'countryName' => Yii::t('app', 'Country'),
                'endUsers'    => Yii::t('app', 'End-Users'),
                'systems'     => Yii::t('app', 'Systems'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPurchaseOrders()
        {
            return $this->hasMany(PurchaseOrder::className(), ['distributor_id' => 'id']);
        }

        public function getUser()
        {
            return User::findOne(['id' => $this->user_id]);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDistributorsCountries()
        {
            return $this->hasMany(DistributorCountry::className(), ['distributor_id' => 'id']);
        }

        /**
         * Returns array of end users assigned to purchase orders which belongs to this distributor
         *
         * @return EndUser[]|array
         */
        public function getEndUsers()
        {
            $endUsers = [];
            $purchaseOrders = $this->purchaseOrders;
            foreach ($purchaseOrders as $purchaseOrder) {
                $endUsers[] = $purchaseOrder->endUser;
            }

            return $endUsers;
        }

        /**
         * Returns array of systems assigned to purchase orders which belongs to this distributor
         *
         * @return System[]|array
         */
        public function getSystems()
        {
            $systems = [];
            $purchaseOrders = $this->purchaseOrders;

            foreach ($purchaseOrders as $purchaseOrder) {
                $systems[] = $purchaseOrder->system;
            }

            return $systems;
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCountries()
        {
            return $this->hasMany(Country::className(), ['id_countries' => 'country_id'])->viaTable('distributors_countries', ['distributor_id' => 'id']);
        }

        public function getCountryName()
        {
            return isset($this->countries[0]) ? $this->countries[0]->name : null; //TODO Distributors possibly will have more than one country
        }

        public function getCountryId()
        {
            return isset($this->countries[0]) ? $this->countries[0]->id_countries : null;
        }

        public function saveCountry()
        {

            DistributorCountry::deleteAll(['distributor_id' => $this->id]);

            if ($this->country_id) {
                $distCountry = new DistributorCountry();
                $distCountry->country_id = $this->country_id;
                $distCountry->distributor_id = $this->id;

                return $distCountry->save() ? true : false;

            }
        }

        public function beforeDelete()
        {
            if (parent::beforeDelete()) {
                DistributorCountry::deleteAll(['distributor_id' => $this->id]);

                return true;
            } else {
                return false;
            }
        }

        /**
         * @return boolean
         */
        public function saveModel()
        {
            $user = new User();
            $user->email = $this->email;
            $user->first_name = $this->title;
            $user->password = Yii::$app->security->generateRandomString(8);
            $user->password_repeat = $user->password;
            $user->roleField = User::ROLE_DISTR;

            if ($user->saveModel()) {
                $this->user_id = $user->id;
                if ($this->save()) {
                    $this->saveCountry();

                    return true;
                }
            } else {
                if (is_array($user->errors)) {
                    foreach ($user->errors as $attribute => $error) {
                        $this->addError($attribute, $error[0]);
                    }
                }

                return false;
            }
        }

        /**
         * @return boolean
         */
        public function updateModel()
        {
            if ($this->save()) {
                $this->saveCountry();

                return true;
            } else {
                return false;
            }
        }

        public function afterFind()
        {
            parent::afterFind();
            $this->country_id = $this->getCountryId();
        }
    }
