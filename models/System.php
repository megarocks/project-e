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
    class System extends \yii\db\ActiveRecord
    {
        const STATUS_UNLOCKED = "unlocked";
        const STATUS_ACTIVE = "active";
        const STATUS_ACTIVE_PAYMENT = "active_payment";
        const STATUS_LOCKED = "locked";

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

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'               => 'ID',
                'sn'               => Yii::t('app', 'System SN'),
                'po'               => Yii::t('app', 'Purchase Order #'),
                'status'           => Yii::t('app', 'Status'),
                'current_code'     => Yii::t('app', 'Current Code'),
                'next_lock_date'   => Yii::t('app', 'Next Locking Date'),
                'init_lock_date'   => Yii::t('app', 'Initial Locking Date'),
                'main_unlock_code' => Yii::t('app', 'Main unlock Code'),
                'login_code'       => Yii::t('app', 'Login Code'),
                'created_at'       => Yii::t('app', 'Created At'),
                'updated_at'       => Yii::t('app', 'Updated At'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPurchaseOrder()
        {
            return $this->hasOne(PurchaseOrder::className(), ['system_sn' => 'sn']);
        }

        private function generateLockingParams()
        {
            $this->main_unlock_code = Yii::$app->security->generateRandomString(10); //TODO Code generation logic will be here
            $this->next_lock_date = date("Y-m-d", strtotime("+3 months"));
            $this->init_lock_date = date("Y-m-d", strtotime("today"));
            $this->current_code = Yii::$app->security->generateRandomString(10);
            $this->status = static::STATUS_ACTIVE_PAYMENT;
            $this->login_code = Yii::$app->security->generateRandomString(6);
        }

        public function beforeSave($insert)
        {
            if (parent::beforeSave($insert)) {
                if ($insert) {
                    $this->generateLockingParams();
                }

                return true;
            } else {
                return false;
            }
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
            $this->current_code = $lockDates[0]['date'];
            $this->save();
        }

        public function registerSystem()
        {
            if ($this->validate()) {
                return $this->save();
            } else {
                return false;
            }
        }

    }
