<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\base\Security;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "systems".
     *
     * @property integer $id
     * @property integer $sn
     * @property integer $status
     * @property string $current_code
     * @property string $next_lock_date
     * @property string $init_lock_date
     * @property string $access_token
     *
     * @property string $main_unlock_code
     * @property string $login_code
     * @property string $created_at
     * @property string $updated_at
     *
     * @property string $nextLockingDate
     * @property string $initialLockingDate
     * @property PurchaseOrder $purchaseOrder
     * @property string $systemStatus
     */
    class System extends PpdBaseModel
    {
        const STATUS_UNASSIGNED = "0";
        const STATUS_UNLOCKED = "1";
        const STATUS_ACTIVE = "2";
        const STATUS_ACTIVE_PAYMENT = "3";
        const STATUS_LOCKED = "4";

        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'systems';
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
                [['sn'], 'required'],
                [['sn', 'status'], 'integer'],
                [['sn'], 'unique'],
                [['login_code'], 'string'],
                [['next_lock_date', 'init_lock_date', 'created_at', 'updated_at', 'sn'], 'safe'],
                [['current_code', 'main_unlock_code'], 'string', 'max' => 512]
            ];
        }

        public function fields()
        {
            return [
                'id', 'sn', 'current_code', 'login_code',
                'status'         => function () {
                    $status = '';
                    switch ($this->status) {
                        case static::STATUS_UNASSIGNED:
                            $status = Yii::t('app', 'Unassigned');
                            break;
                        case static::STATUS_UNLOCKED:
                            $status = Yii::t('app', 'Unlocked');
                            break;
                        case static::STATUS_ACTIVE_PAYMENT:
                            $status = Yii::t('app', 'Active/Payment');
                            break;
                        case static::STATUS_ACTIVE:
                            $status = Yii::t('app', 'Active');
                            break;
                        case static::STATUS_LOCKED:
                            $status = Yii::t('app', 'Locked');
                            break;
                    }

                    return $status;
                },
                'po_num'         => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->po_num : null;
                },
                'next_lock_date' => function () {
                    return isset($this->next_lock_date) ? date('M d, Y', strtotime($this->next_lock_date)) : null;
                },
                'init_lock_date' => function () {
                    return isset($this->init_lock_date) ? date('M d, Y', strtotime($this->init_lock_date)) : null;
                },
                'dtpl'           => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->dtpl : null;
                },
                'ctpl'           => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->ctpl : null;
                },
                'country'        => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->country : null;
                },
                'distributor'    => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->distributor : null;
                },
                'endUser'        => function () {
                    return isset($this->purchaseOrder) ? $this->purchaseOrder->endUser : null;
                },
                'created_at'     => function () {
                    return date('M j Y h:i A', strtotime($this->created_at));
                },
                'updated_at'     => function () {
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
                'id'               => 'ID',
                'sn'               => Yii::t('app', 'System SN'),
                'po'               => Yii::t('app', 'Purchase order #'),
                'status'           => Yii::t('app', 'Status'),
                'current_code'     => Yii::t('app', 'Current code'),
                'next_lock_date'   => Yii::t('app', 'Next locking date'),
                'init_lock_date'   => Yii::t('app', 'Initial locking date'),
                'main_unlock_code' => Yii::t('app', 'Main unlock code'),
                'login_code'       => Yii::t('app', 'Login code'),
                'created_at'       => Yii::t('app', 'Created at'),
                'updated_at'       => Yii::t('app', 'Updated at'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPurchaseOrder()
        {
            return $this->hasOne(PurchaseOrder::className(), ['system_sn' => 'sn']);
        }

        /**
         * Generates and sets initial system/po values
         * This method is called on assigning of PO to system
         */
        public function generateLockingParams()
        {
            $this->status = static::STATUS_ACTIVE_PAYMENT;
            $this->main_unlock_code = Yii::$app->security->generateRandomString(10); //TODO Code generation logic will be here
            $this->next_lock_date = date("Y-m-d", strtotime("today"));
            $this->init_lock_date = date("Y-m-d", strtotime("today"));
            $this->current_code = Yii::$app->security->generateRandomString(10);
            $this->login_code = Yii::$app->security->generateRandomString(6);
        }

        public function resetLockingParams()
        {
            $this->status = static::STATUS_UNASSIGNED;
            $this->main_unlock_code = null;
            $this->next_lock_date = null;
            $this->init_lock_date = null;
            $this->current_code = null;
            $this->login_code = null;
        }

        public static function getByLoginCode($code)
        {
            return static::findOne(['login_code' => $code]);
        }

        public static function findBySN($sn)
        {
            return static::findOne(['sn' => $sn]);
        }

        public static function findByAccessToken($token)
        {
            return static::findOne(['access_token' => $token]);
        }

        public function getLockingDates($for)
        {
            $lockingDates = [];
            $resultLockingDates = [];

            //create array with all locking dates starting from initial lock date
            for ($i = 1; $i <= $this->purchaseOrder->nop; $i++) {
                $dateVal = strtotime('+' . $i . 'month ' . $this->init_lock_date);
                $lockingDate['date'] = date('M j Y', $dateVal);
                $lockingDates[$i] = $lockingDate;
            }

            if ($for == Payment::FROM_DISTR) {
                //leave only unclosed locking dates
                if ($this->purchaseOrder->dnpl <= 0) {
                    return [];
                }
                $lockingDates = array_slice($lockingDates, -$this->purchaseOrder->dnpl);
            } elseif ($for == Payment::FROM_USER) {
                if ($this->purchaseOrder->cnpl <= 0) {
                    return [];
                }
                $lockingDates = array_slice($lockingDates, -$this->purchaseOrder->cnpl);
            }

            for ($j = 0; $j <= count($lockingDates) - 1; $j++) {
                $resultLockingDates[$j + 1] = $lockingDates[$j];
                $resultLockingDates[$j + 1]['periods'] = $j + 1;
            }

            return $resultLockingDates;
        }

        public function updateLockingData()
        {
            $lockDates = $this->getLockingDates(Payment::FROM_USER);    //locking params are updated only when user is do payment (or admin on behalf of user)
            if (count($lockDates) > 0) {
                $this->next_lock_date = date('Y-m-d', strtotime('-30 days', strtotime($lockDates[1]['date'])));  //TODO Possible here date is shifted and incorrect
                $this->current_code = Yii::$app->security->generateRandomString(10);
            } else {
                $this->current_code = $this->main_unlock_code;
                $this->next_lock_date = date('Y-m-d', strtotime('today'));
                $this->status = static::STATUS_UNLOCKED;
            }
            $this->save();
        }

        public function getNextLockingDate()
        {
            return (!is_null($this->next_lock_date)) ? date('M j Y', strtotime($this->next_lock_date)) : null;
        }

        public function getInitialLockingDate()
        {
            return (!is_null($this->init_lock_date)) ? date('M j Y', strtotime($this->init_lock_date)) : null;
        }

        public function getSystemStatus()
        {
            $status = '';
            switch ($this->status) {
                case static::STATUS_UNASSIGNED:
                    $status = Yii::t('app', 'Unassigned');
                    break;
                case static::STATUS_UNLOCKED:
                    $status = Yii::t('app', 'Unlocked');
                    break;
                case static::STATUS_ACTIVE_PAYMENT:
                    $status = Yii::t('app', 'Active/Payment');
                    break;
                case static::STATUS_ACTIVE:
                    $status = Yii::t('app', 'Active');
                    break;
                case static::STATUS_LOCKED:
                    $status = Yii::t('app', 'Locked');
                    break;
            }

            return $status;
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            if ($this->validate()) {
                $this->status = static::STATUS_UNASSIGNED;
                $this->access_token = Yii::$app->security->generateRandomString();
                return $this->save();
            } else {
                return false;
            }
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
            if (!is_null($this->purchaseOrder)) {
                return false;
            } else {
                return $this->delete();
            }
        }
    }
