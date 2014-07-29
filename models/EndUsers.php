<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "end_users".
 *
 * @property integer $id
 * @property string $email
 *
 * @property Systems[] $systems
 */
class EndUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'end_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(Systems::className(), ['end_user_id' => 'id']);
    }
}
