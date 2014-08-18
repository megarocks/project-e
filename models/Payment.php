<?php

    namespace app\models;

    use Yii;

    /**
     * This is the model class for table "payments".
     *
     * @property integer $id
     * @property integer $po_num
     * @property string $amount
     * @property integer $periods
     * @property string $currency_code
     * @property string $transaction_id
     * @property string $payer_id
     * @property string $payer_email
     *
     * @property Po $poNum
     */
    class Payment extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'payments';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['po_num', 'amount', 'periods', 'currency_code', 'transaction_id', 'payer_id', 'payer_email'], 'required'],
                [['po_num', 'periods'], 'integer'],
                [['amount'], 'number'],
                [['currency_code'], 'string', 'max' => 3],
                [['transaction_id', 'payer_id', 'payer_email'], 'string', 'max' => 45]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'             => Yii::t('app', 'ID'),
                'po_num'         => Yii::t('app', 'Po Num'),
                'amount'         => Yii::t('app', 'Amount'),
                'periods'        => Yii::t('app', 'Periods'),
                'currency_code'  => Yii::t('app', 'Currency Code'),
                'transaction_id' => Yii::t('app', 'Transaction ID'),
                'payer_id'       => Yii::t('app', 'Payer ID'),
                'payer_email'    => Yii::t('app', 'Payer Email'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPoNum()
        {
            return $this->hasOne(Po::className(), ['po_num' => 'po_num']);
        }

        public function loadDataFromPayPal($po_num, $paymentDetails, $confirmDetails)
        {
            $this->po_num = $po_num;
            $this->amount = $confirmDetails['PAYMENTINFO_0_AMT'];
            $this->periods = $paymentDetails['L_QTY0'];
            $this->currency_code = $confirmDetails['PAYMENTINFO_0_CURRENCYCODE'];
            $this->transaction_id = $confirmDetails['PAYMENTINFO_0_TRANSACTIONID'];
            $this->payer_id = $paymentDetails['PAYERID'];
            $this->payer_email = $paymentDetails['EMAIL'];

            return true;
        }
    }
