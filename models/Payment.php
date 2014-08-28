<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

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
     * @property string $method
     * @property string $from
     *
     * @property PurchaseOrder $po
     */
    class Payment extends \yii\db\ActiveRecord
    {
        //source of information regards payment
        const METHOD_PAYPAL = 'paypal';
        const METHOD_MANUAL = 'manual';

        const FROM_USER = 'enduser';
        const FROM_DISTR = 'distributor';


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
                [['po_num', 'amount', 'periods', 'currency_code', 'payer_email', 'from'], 'required'],
                [['po_num', 'amount', 'periods', 'currency_code', 'transaction_id', 'payer_id', 'payer_email', 'from', 'method'], 'safe'],
                [['po_num', 'periods'], 'integer'],
                [['amount'], 'number'],
                [['currency_code'], 'string', 'max' => 3],
                [['transaction_id', 'payer_id', 'payer_email'], 'string', 'max' => 45],
                [['transaction_id', 'payer_id'], 'required', 'on' => ['paypal']],
                [['from'], 'required', 'on' => ['manual']]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'             => Yii::t('app', 'Payment ID'),
                'po_num'         => Yii::t('app', 'Purchase Order #'),
                'amount'         => Yii::t('app', 'Payment Amount'),
                'periods'        => Yii::t('app', 'Payed Periods'),
                'currency_code' => Yii::t('app', 'Currency'),
                'transaction_id' => Yii::t('app', 'Transaction ID'),
                'payer_id'       => Yii::t('app', 'Payer ID'),
                'payer_email'    => Yii::t('app', 'Payer Email'),
                'from'          => Yii::t('app', 'Payment From'),
                'method'        => Yii::t('app', 'Payment Method'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPurchaseOrder()
        {
            return $this->hasOne(PurchaseOrder::className(), ['po_num' => 'po_num']);
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
            $this->source = static::METHOD_PAYPAL;

            return true;
        }
    }
