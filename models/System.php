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
            'sn' => 'Sn',
            'po' => 'PO#',
            'status' => 'Status',
            'current_code' => 'Current Code',
            'next_lock_date' => 'Next Lock Date',
            'main_unlock_code' => 'Main Unlock Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'purchaseOrder' => 'Purchase Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::className(), ['system_sn' => 'sn']);
    }
}
