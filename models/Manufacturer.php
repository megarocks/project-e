<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 23.09.14
     * Time: 15:23
     */

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;
    use app\models\User;

    /**
     *
     * @property integer $id
     * @property integer $user_id
     * @property string $phone
     * @property string $created_at
     * @property string $updated_at
     *
     * @property User $user
     */
    class Manufacturer extends PpdBaseModel
    {

        public static function tableName()
        {
            return 'manufacturers';
        }

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

        public function rules()
        {
            return [
                [['user_id'], 'required'],
                [['phone'], 'string', 'max' => 45],
                [['user_id', 'phone', 'created_at', 'updated_at'], 'safe']
            ];
        }

        public function fields()
        {
            return [
                'id', 'user_id', 'phone', 'title', 'email',
                'created_at' => function () {
                    return date('M j Y h:i A', strtotime($this->created_at));
                },
                'updated_at' => function () {
                    return (!is_null($this->updated_at)) ? date('M j Y h:i A', strtotime($this->updated_at)) : null;
                }
            ];
        }

        public function extraFields()
        {
            return [
                'user',
            ];
        }

        public function attributeLabels()
        {
            return [
                'id'         => Yii::t('app', ''),
                'user_id'    => Yii::t('app', 'User'),
                'phone'      => Yii::t('app', 'Phone'),
                'created_at' => Yii::t('app', 'Created at'),
                'updated_at' => Yii::t('app', 'Updated at'),
                'user'       => Yii::t('app', 'User'),
            ];
        }

        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        public function getTitle()
        {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }

        public function getEmail()
        {
            return $this->user->email;
        }

        public function createModel()
        {
            return $this->save();
        }

        public function updateModel()
        {
            return $this->save();
        }

        public function deleteModel()
        {
            if ($this->user->delete()) {
                return $this->delete();
            } else {
                return false;
            }
        }
    }