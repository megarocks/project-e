<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "distributors".
     *
     * @property integer $id
     * @property string $title
     * @property string $email
     * @property string $created_at
     * @property string $updated_at
     * @property string $countryName;
     * @property int $countryId;
     *
     * @property DistributorCountry[] $distributorsCountries
     * @property Country[] $countries
     * @property PurchaseOrder[] $pos
     */
    class Distributor extends \yii\db\ActiveRecord
    {
        public $countryId; //temp  country id storage
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
                [['title'], 'required'],
                [['title', 'email', 'created_at', 'updated_at'], 'string', 'max' => 45],
                [['countryId'], 'safe']
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
                'countryId'   => Yii::t('app', 'Country Id'),
                'countryName' => Yii::t('app', 'Country'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDistributorsCountries()
        {
            return $this->hasMany(DistributorCountry::className(), ['distributor_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCountries()
        {
            return $this->hasMany(Country::className(), ['id_countries' => 'country_id'])->viaTable('distributors_countries', ['distributor_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPos()
        {
            return $this->hasMany(PurchaseOrder::className(), ['distributor_id' => 'id']);
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

            if ($this->countryId) {
                $distCountry = new DistributorCountry();
                $distCountry->country_id = $this->countryId;
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
    }
