<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distributors".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $email
 *
 * @property Systems[] $systems
 */
class Distributors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distributors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'email'], 'required'],
            [['first_name', 'email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(Systems::className(), ['distributor_id' => 'id']);
    }
}
