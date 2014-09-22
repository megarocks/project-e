<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "systems".
     *
     * @property integer $id
     * @property integer $sn
     * @property string $status
     * @property string $current_code
     * @property string $next_lock_date
     * @property string $init_lock_date
     *
     * @property string $main_unlock_code
     * @property string $login_code
     * @property string $created_at
     * @property string $updated_at
     *
     * @property PurchaseOrder $purchaseOrder
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
                [['sn'], 'integer'],
                [['sn'], 'unique'],
                [['status', 'login_code'], 'string'],
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
            $this->next_lock_date = date("Y-m-d", strtotime("+1 month"));
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

        public function getLockingDates()
        {
            $lockingDates = [];

            //generating values for all periods staring from initial lock date
            for ($i = 1; $i <= $this->purchaseOrder->nop; $i++) {
                $dateVal = strtotime('+' . $i . 'month ' . $this->init_lock_date);
                $lockingDate['date'] = date('Y-m-d', $dateVal);
                $lockingDates[] = $lockingDate;
            }
            //leaving only periods which are left to pay
            $lockingDates = array_slice($lockingDates, -$this->purchaseOrder->npl);

            for ($j = 0; $j < count($lockingDates); $j++) {
                $dateVal = strtotime($lockingDates[$j]['date']);
                $lockingDates[$j]['periods'] = $j + 1;
                if ($j == 0) {
                    $lockingDates[$j]['pretty_date'] = $j + 1 . ' period. Next locking date: ' . date('F j, Y', $dateVal);
                } elseif ($j == count($lockingDates)) {
                    $lockingDates[$j]['pretty_date'] = $j + 1 . ' periods. This will unlock system totally';
                } else {
                    $lockingDates[$j]['pretty_date'] = $j + 1 . ' periods. Next locking date: ' . date('F j, Y', $dateVal);
                }

            }

            return $lockingDates;
        }

        public function updateLockingData()
        {
            $lockDates = $this->getLockingDates();
            $this->next_lock_date = $lockDates[0]['date'];
            $this->current_code = Yii::$app->security->generateRandomString(10);
            $this->save();
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            if ($this->validate()) {
                $this->status = static::STATUS_UNASSIGNED;

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
