<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_emails".
 *
 * @property integer $id
 * @property integer $system_id
 * @property string $email
 *
 * @property Systems $system
 */
class SystemEmails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_emails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['system_id', 'email'], 'required'],
            [['system_id'], 'integer'],
            [['email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system_id' => 'System ID',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(Systems::className(), ['id' => 'system_id']);
    }
}
