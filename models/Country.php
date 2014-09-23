<?php

    namespace app\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "countries".
     *
     * @property integer $id
     * @property string $name
     * @property string $iso_alpha2
     * @property string $iso_alpha3
     * @property integer $iso_numeric
     * @property string $currency_code
     * @property string $currency_name
     * @property string $currency_symbol
     * @property string $flag
     *
     * @property PurchaseOrder[] $orders
     * @property Distributor[] $distributors
     * @property EndUser[] $endUsers
     */
    class Country extends ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'countries';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['id'], 'required'],
                [['id', 'iso_numeric'], 'integer'],
                [['name'], 'string', 'max' => 200],
                [['iso_alpha2'], 'string', 'max' => 2],
                [['iso_alpha3', 'currency_code', 'currency_symbol'], 'string', 'max' => 3],
                [['currency_name'], 'string', 'max' => 32],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'Country Id',
                'name'            => 'Name',
                'iso_alpha2'      => 'Iso Alpha2',
                'iso_alpha3'      => 'Iso Alpha3',
                'iso_numeric'     => 'Iso Numeric',
                'currency_code'   => 'Currency Code',
                'currency_name'   => 'Currency Name',
                'currency_symbol' => 'Currency Symbol',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPOs()
        {
            return $this->hasMany(PurchaseOrder::className(), ['country_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDistributors()
        {
            return $this->hasMany(Distributor::className(), ['country_id' => 'id']);
        }

        /**
         * @return EndUser
         */
        public function getEndUsers()
        {
            return $this->hasMany(EndUser::className(), ['country_id' => 'id']);
        }
    }
