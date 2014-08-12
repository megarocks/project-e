<?php

    namespace app\models;

    use Yii;

    /**
     * This is the model class for table "end_users".
     *
     * @property integer $id
     * @property string $title
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
                'id'    => 'ID',
                'title' => Yii::t('app', 'Title'),
                'email' => Yii::t('app', 'Email'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSystems()
        {
            return $this->hasMany(System::className(), ['end_user_id' => 'id']);
        }
    }
