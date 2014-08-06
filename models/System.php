<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "systems".
 *
 * @property integer $id
 * @property integer $sn
 * @property integer $po
 * @property string $status
 * @property string $current_code
 * @property string $next_lock_date
 * @property string $main_unlock_code
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Po $po0
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
    public function rules()
    {
        return [
            [['sn'], 'required'],
            [['sn', 'po'], 'integer'],
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
            'po' => 'Po',
            'status' => 'Status',
            'current_code' => 'Current Code',
            'next_lock_date' => 'Next Lock Date',
            'main_unlock_code' => 'Main Unlock Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPo0()
    {
        return $this->hasOne(Po::className(), ['id' => 'po']);
    }
}
