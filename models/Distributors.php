<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distributors".
 *
 * @property integer $id
 * @property string $title
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
            [['title'], 'required'],
            [['title', 'email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
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
