<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "end_users".
     *
     * @property integer $id
     * @property integer $distributor_id
     * @property integer $user_id
     * @property string  $phone
     * @property string  $contact_person
     * @property integer $country_id
     * @property string $created_at
     * @property string $updated_at
     *
     * @property User $user
     * @property string $title
     * @property string $email
     * @property PurchaseOrder[] $orders
     * @property Country $country
     * @property System[] $systems
     *
     *
     */
    class EndUser extends PpdBaseModel
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'end_users';
        }

        /**
         * @inheritdoc
         */
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
                [['user_id', 'country_id', 'distributor_id'], 'required'],
                [['phone'], 'string', 'max' => 45],
                [['contact_person'], 'string', 'max' => 128],
                [['user_id', 'country_id', 'phone', 'created_at', 'updated_at', 'contact_person'], 'safe']
            ];
        }

        public function fields()
        {
            return [
                'id', 'user_id', 'title', 'email', 'country_id', 'contact_person',
                'created_at' => function () {
                    return date('M j Y h:i A', strtotime($this->created_at));
                },
                'updated_at' => function () {
                    return (!is_null($this->updated_at)) ? date('M j Y h:i A', strtotime($this->updated_at)) : null;
                }
            ];
        }

        public function extraFields()
        {
            return [
                'user', 'country', 'orders', 'systems',
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'title'      => Yii::t('app', 'Title'),
                'email'      => Yii::t('app', 'Email'),
                'systems'    => Yii::t('app', 'Systems'),
                'orders' => Yii::t('app', 'Purchase Orders'),
                'country'    => Yii::t('app', 'Country'),
                'user'       => Yii::t('app', 'User'),
                'country_id' => Yii::t('app', 'Country'),
                'distributor_id' => Yii::t('app', 'Distributor'),
            ];
        }

        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        public function getTitle()
        {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }

        public function getEmail()
        {
            return $this->user->email;
        }

        public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id' => 'country_id']);
        }

        public function getOrders()
        {
            return $this->hasMany(PurchaseOrder::className(), ['end_user_id' => 'id']);
        }

        public function getSystems()
        {
            $result = [];
            foreach ($this->orders as $order) {
                $result[] = $order->system;
            }

            return $result;
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            /*            if ($this->validate()) {
                            $user = new User();
                            $user->email = $this->email;
                            $user->first_name = $this->title;
                            $user->password = Yii::$app->security->generateRandomString(8);
                            $user->password_repeat = $user->password;
                            $user->roleField = User::ROLE_END_USER;

                            if ($user->createModel()) {
                                $this->user_id = $user->id;
                                if ($this->save()) {
                                    return true;
                                } else {
                                    return false;
                                }
                            } else {
                                if (is_array($user->errors)) {
                                    foreach ($user->errors as $attribute => $error) {
                                        $this->addError($attribute, $error[0]);
                                    }
                                }

                                return false;
                            }
                        } else {
                            return false;
                        }*/
            return $this->save();
        }

        /**
         * @return boolean
         */
        public function updateModel()
        {
            return $this->save();
        }

        /**
         * @return boolean
         */
        public function deleteModel()
        {
            return $this->delete();
        }
    }
