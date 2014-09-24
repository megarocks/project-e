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
     * @property number $amount
     * @property integer $periods
     * @property string $currency_code
     * @property string $transaction_id
     * @property string $payer_id
     * @property string $payer_email
     * @property string $method
     * @property string $from
     * @property string $created_at
     *
     * @property PurchaseOrder $purchaseOrder
     */
    class Payment extends PpdBaseModel
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
                [['po_num', 'periods'], 'required'],
                [['po_num', 'amount', 'periods', 'currency_code', 'transaction_id', 'payer_id', 'payer_email', 'from', 'method'], 'safe'],
                [['po_num'], 'integer'],
                [['amount'], 'number', 'min' => 1],
                [['periods'], 'integer', 'min' => 1],
                [['currency_code'], 'string', 'max' => 3],
                [['transaction_id', 'payer_id', 'payer_email'], 'string', 'max' => 45],
                [['transaction_id', 'payer_id'], 'required', 'on' => ['paypal']],
                [['from'], 'required', 'on' => ['manual']]
            ];
        }

        public function fields()
        {
            return [
                'id', 'po_num', 'amount', 'periods', 'currency_code', 'payer_email', 'method',
                'created_at' => function () {
                    return date('M j Y h:i A', strtotime($this->created_at));
                },
                'updated_at' => function () {
                    return (!is_null($this->updated_at)) ? date('M j Y h:i A', strtotime($this->updated_at)) : null;
                }
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
                'currency_code'  => Yii::t('app', 'Currency'),
                'transaction_id' => Yii::t('app', 'Transaction ID'),
                'payer_id'       => Yii::t('app', 'Payer ID'),
                'payer_email'    => Yii::t('app', 'Payer Email'),
                'from'           => Yii::t('app', 'Payment From'),
                'method'         => Yii::t('app', 'Payment Method'),
                'created_at'     => Yii::t('app', 'Payment Date/Time'),
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
            $this->method = static::METHOD_PAYPAL;

            $this->po_num = $po_num;
            $this->amount = $confirmDetails['PAYMENTINFO_0_AMT'];
            $this->periods = $paymentDetails['L_QTY0'];
            $this->currency_code = $confirmDetails['PAYMENTINFO_0_CURRENCYCODE'];
            $this->transaction_id = $confirmDetails['PAYMENTINFO_0_TRANSACTIONID'];
            $this->payer_id = $paymentDetails['PAYERID'];
            $this->payer_email = $paymentDetails['EMAIL'];
            $this->from = $paymentDetails['CUSTOM'];

            return true;
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            $order = PurchaseOrder::findOne(['po_num' => $this->po_num]);
            $this->currency_code = $order->currency_code;
            if ($this->from == static::FROM_DISTR) {
                $this->amount = $this->periods * $order->dmp;
                $this->payer_email = $order->distributor->email;
            } elseif ($this->from == static::FROM_USER) {
                $this->amount = $this->periods * $order->cmp;
                $this->payer_email = $order->endUser->email;
            }

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
            //TODO Implement Payment Revoke logic
            return $this->delete();
        }
    }
