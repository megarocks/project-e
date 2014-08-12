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
 * @property string $main_unlock_code
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
                'class' => DateTimeStampBehavior::className(),
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
            [['status'], 'string'],
            [['next_lock_date', 'created_at', 'updated_at'], 'safe'],
            [['current_code', 'main_unlock_code'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => Yii::t('app', 'System SN'),
            'po' => Yii::t('app', 'Purchase Order #'),
            'status' => Yii::t('app', 'Status'),
            'current_code' => Yii::t('app', 'Current Code'),
            'next_lock_date' => Yii::t('app', 'Next Locking Date'),
            'main_unlock_code' => Yii::t('app', 'Main unlock Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        $this->current_code = Yii::$app->security->generateRandomString(10);
        $this->status = static::STATUS_ACTIVE_PAYMENT;
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

}
