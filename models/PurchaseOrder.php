<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\web\ForbiddenHttpException;

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
     * @property integer $dnpl
     * @property integer $cnpl
     * @property number $cmp
     * @property number $dmp
     * @property number $ctpl
     * @property number $dtpl
     * @property integer $end_user_id
     * @property integer $distributor_id
     * @property integer $country_id
     * @property string $currency_code
     * @property string $email
     * @property string $created_at
     * @property string $updated_at
     * @property integer $system_sn
     *
     * @property Payment[] $payments
     * @property EndUser $endUser
     * @property Country $country
     * @property Distributor $distributor
     * @property System $system
     * @property boolean $editable
     * @property string lastPaymentDate
     */
    class PurchaseOrder extends PpdBaseModel
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
                [['po_num', 'country_id', 'currency_code', 'distributor_id', 'end_user_id', 'nop', 'cpup', 'dpup', 'dsp', 'csp'], 'required'],
                [['cpup', 'dpup', 'dsp', 'csp', 'cmp', 'dmp', 'ctpl', 'dtpl'], 'number', 'min' => 0],
                [['po_num', 'end_user_id', 'distributor_id', 'country_id', 'system_sn'], 'integer'],
                [['created_at', 'updated_at', 'currency_code'], 'safe'],
                [['system_sn', 'po_num'], 'unique'],
                [['nop'], 'integer', 'min' => 1],
                [['dnpl', 'cnpl'], 'integer', 'min' => 0],
                ['cpup',
                    'compare',
                    'skipOnError'      => true,
                    'operator'         => '<=',
                    'compareAttribute' => 'csp',
                    'message'          => Yii::t('yii', 'Customer payment upon purchase must be no greater than customer system price.')],
                ['dpup',
                    'compare',
                    'skipOnError'      => true,
                    'operator'         => '<=',
                    'compareAttribute' => 'dsp',
                    'message'          => Yii::t('yii', 'Distributor payment upon purchase must be no greater than distributor system price.')],
            ];
        }

        public function fields()
        {
            return [
                'id', 'po_num', 'cpup', 'dpup', 'dsp', 'csp', 'nop', 'ctpl', 'dtpl', 'cnpl', 'dnpl', 'system_sn', 'distributor', 'country', 'endUser', 'lastPaymentDate',
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
                'dpup'           => Yii::t('app', 'DPUP (Distributor Payment Upon Purchase)'),
                'dsp'            => Yii::t('app', 'DSP (Distributor System Price)'),
                'csp'            => Yii::t('app', 'CSP (Customer System Price)'),
                'nop'            => Yii::t('app', 'NOP (Number of payments in plan)'),
                'cmp'            => Yii::t('app', 'CMP (Customer Monthly Payment)'),
                'dmp'            => Yii::t('app', 'DMP (Distributor Monthly Payment)'),
                'dnpl'           => Yii::t('app', 'DNPL (Distributor Number of payments left)'),
                'cnpl'           => Yii::t('app', 'CNPL (Customer Number of payments left)'),
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
            return $this->hasOne(Country::className(), ['id' => 'country_id']);
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

        public function getPayments()
        {
            return $this->hasMany(Payment::className(), ['po_num' => 'po_num']);
        }

        private function calculateValues($calculateMonthlyPayments = false)
        {
            if ($calculateMonthlyPayments) {
                //calculate monthly payment value
                $this->cmp = ($this->cnpl == 0) ? 0 : ($this->csp - $this->cpup) / $this->cnpl;
                $this->dmp = ($this->dnpl == 0) ? 0 : ($this->dsp - $this->dpup) / $this->dnpl;
            }

            //calculate rest amount to pay
            $this->ctpl = $this->cmp * $this->cnpl;
            $this->dtpl = $this->dmp * $this->dnpl;

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

            if ($payment->from == Payment::FROM_DISTR) {
                $this->dnpl = $this->dnpl - $payment->periods;
                $this->calculateValues();
                $this->save();

            } elseif ($payment->from == Payment::FROM_USER) {
                $this->cnpl = $this->cnpl - $payment->periods;
                $this->calculateValues();
                $this->save();
                $this->system->updateLockingData();
            }
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

            switch ($payment->from) {
                case Payment::FROM_DISTR:
                    $this->dnpl = $this->dnpl + $payment->periods;
                    break;
                case Payment::FROM_USER:
                    $this->cnpl = $this->cnpl + $payment->periods;
                    break;
                default:
                    break;
            }

            $this->calculateValues();
            $this->save();
            $this->system->updateLockingData();

            return true;
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            $this->cpup >= $this->csp ? $this->cnpl = 0 : $this->cnpl = $this->nop;
            $this->dpup >= $this->dsp ? $this->dnpl = 0 : $this->dnpl = $this->nop;

            $this->calculateValues(true);

            return $this->save();
        }

        /**
         * @throws ForbiddenHttpException
         * @return boolean
         */
        public function updateModel()
        {
            if ($this->editable) {
                $this->cpup >= $this->csp ? $this->cnpl = 0 : $this->cnpl = $this->nop;
                $this->dpup >= $this->dsp ? $this->dnpl = 0 : $this->dnpl = $this->nop;

                $this->calculateValues(true);

                return $this->save();
            } else {
                throw new ForbiddenHttpException('This order is not editable');
            }
        }

        /**
         * @return boolean
         */
        public function deleteModel()
        {
            if (!$this->editable) {
                return false;
            } elseif (!is_null($this->system)) {
                return false;
            } else {
                return $this->delete();
            }
        }

        public function getEditable()
        {
            return (count($this->payments) == 0);
        }

        public function getLastPaymentDate()
        {
            if (count($this->payments) > 0) {
                $lastElementIndex = count($this->payments) - 1;
                $lastPayment = $this->payments[$lastElementIndex];

                return $lastPayment->createdAt;
            } else {
                return null;
            }
        }
    }
