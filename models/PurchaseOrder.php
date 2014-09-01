<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "po".
     *
     * @property integer $id
     * @property integer $po_num
     * @property number $cpup
     * @property number $dpup
     * @property number $dsp
     * @property number $csp
     * @property integer $nop
     * @property integer $npl
     * @property number $cmp
     * @property number $dmp
     * @property number $ctpl
     * @property number $dtpl
     * @property integer $end_user_id
     * @property integer $distributor_id
     * @property integer $country_id
     * @property integer $currency_code
     * @property string $email
     * @property string $created_at
     * @property string $updated_at
     * @property integer $system_sn
     *
     *
     * @property EndUser $endUser
     * @property Country $country
     * @property Distributor $distributor
     * @property System $system
     */
    class PurchaseOrder extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'po';
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
                [['po_num', 'country_id', 'email', 'currency_code', 'distributor_id', 'end_user_id', 'nop'], 'required'],
                [['cpup', 'dpup', 'dsp', 'csp', 'cmp', 'dmp', 'ctpl', 'dtpl'], 'number', 'min' => 0],
                [['po_num', 'end_user_id', 'distributor_id', 'country_id', 'system_sn'], 'integer'],
                [['created_at', 'updated_at', 'currency_code'], 'safe'],
                [['email'], 'string', 'max' => 64],
                [['email'], 'email'],
                [['system_sn'], 'unique'],
                [['nop'], 'integer', 'min' => 1],
                [['npl'], 'integer', 'min' => 0],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'             => 'ID',
                'po_num'         => Yii::t('app', 'PO# (Purchase Order Number)'),
                'cpup'           => Yii::t('app', 'CPUP (Customer Payment Upon Purchase)'),
                'dpup'           => Yii::t('app', 'DPUP (Distributor Payment Upon purchase)'),
                'dsp'            => Yii::t('app', 'DSP (Distributor System Price)'),
                'csp'            => Yii::t('app', 'CSP (Customer System Price)'),
                'nop'            => Yii::t('app', 'NOP (Number of payments in plan)'),
                'cmp'            => Yii::t('app', 'CMP (Customer Monthly Payment)'),
                'dmp'            => Yii::t('app', 'DMP (Distributor Monthly Payment)'),
                'npl'            => Yii::t('app', 'NPL (Number of payments left)'),
                'ctpl'           => Yii::t('app', 'CTPL (Customer Total Payment Left)'),
                'dtpl'           => Yii::t('app', 'DTPL (Distributor Total Payment Left)'),
                'end_user_id'    => Yii::t('app', 'End-User'),
                'distributor_id' => Yii::t('app', 'Distributor'),
                'country_id'     => Yii::t('app', 'Country'),
                'currency_code'  => Yii::t('app', 'Currency'),
                'email'          => Yii::t('app', 'Email'),
                'system_sn'      => Yii::t('app', 'System SN'),
                'created_at'     => Yii::t('app', 'Created At'),
                'updated_at'     => Yii::t('app', 'Updated At'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getEndUser()
        {
            return $this->hasOne(EndUser::className(), ['id' => 'end_user_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id_countries' => 'country_id']);
        }

        /**
         * @return string
         */
        public function getCurrency()
        {
            return $this->country->currency_name;
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
        public function getSystem()
        {
            return $this->hasOne(System::className(), ['sn' => 'system_sn']);
        }

        private function calculateValues($initial = true)
        {
            if ($this->nop >= 0) {
                if ($initial) {
                    $this->npl = $this->nop;
                }
                $this->cmp = ($this->csp - $this->cpup) / $this->nop;
                $this->dpup >= $this->dsp ? $this->dmp = 0 : $this->dmp = ($this->dsp - $this->dpup) / $this->nop;
                $this->ctpl = $this->cmp * $this->npl;
                $this->dtpl = $this->dmp * $this->npl;
            } else {
                throw new InvalidParamException('NOP should be positive value');
            }
        }

        /**
         * Updates purchase order params accordingly to payment
         *
         * @param $payment
         * @return bool
         */
        public function processPayment($payment)
        {
            /**@var $payment Payment */
            $this->npl = $this->npl - $payment->periods;

            switch ($payment->from) {
                case Payment::FROM_DISTR:
                    $this->dtpl = $this->dtpl - $payment->amount;
                    break;
                case Payment::FROM_USER:
                    $this->ctpl = $this->ctpl - $payment->amount;
                    break;
                default:
                    break;
            }

            $this->save();
            $this->system->updateLockingData();

            return true;
        }

        /**
         * Revokes changes made to purchase order by payment
         *
         * @param $payment
         * @return bool
         */
        public function revokePayment($payment)
        {
            /**@var $payment Payment */
            $this->npl = $this->npl + $payment->periods;

            switch ($payment->from) {
                case Payment::FROM_DISTR:
                    $this->dtpl = $this->dtpl + $payment->amount;
                    break;
                case Payment::FROM_USER:
                    $this->ctpl = $this->ctpl + $payment->amount;
                    break;
                default:
                    break;
            }
            $this->save();
            $this->system->updateLockingData();

            return true;
        }

        public function createPurchaseOrder()
        {
            $this->calculateValues(true);

            return $this->save();
        }

        public function updatePurchaseOrder()
        {
            $this->calculateValues(false);

            return $this->save();
        }

    }
