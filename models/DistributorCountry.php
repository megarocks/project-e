<?php

    namespace app\models;

    use Yii;

    /**
     * This is the model class for table "distributors_countries".
     *
     * @property integer $distributor_id
     * @property integer $country_id
     *
     * @property Distributor $distributor
     * @property Country $country
     */
    class DistributorCountry extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'distributors_countries';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['distributor_id', 'country_id'], 'required'],
                [['distributor_id', 'country_id'], 'integer']
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'distributor_id' => 'Distributor ID',
                'country_id'     => 'Country ID',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDistributor()
        {
            return $this->hasOne(Distributor::className(), ['id' => 'distributor_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id_countries' => 'country_id']);
        }
    }
