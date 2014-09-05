<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "end_users".
     *
     * @property integer $id
     * @property integer $user_id
     * @property string $title
     * @property string $email
     * @property integer $country_id
     *
     * @property PurchaseOrder $purchaseOrder
     * @property User $user
     * @property Country $country
     *
     * @property string $created_at
     * @property string $updated_at
     */
    class EndUser extends ActiveRecord
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
                [['title', 'email', 'country_id'], 'required'],
                [['title', 'email'], 'string', 'max' => 45],
                [['user_id', 'country_id'], 'integer'],
                [['email'], 'email'],
                [['email'], 'unique'],
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
                'systems'    => Yii::t('app', 'Systems'),
                'country'    => Yii::t('app', 'Country'),
                'user'       => Yii::t('app', 'User'),
                'country_id' => Yii::t('app', 'Country'),
            ];
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
         * @return \yii\db\ActiveQuery
         */
        public function getSystems()
        {
            return $this->hasMany(System::className(), ['end_user_id' => 'id']);
        }

        public function getPurchaseOrder()
        {
            return $this->hasOne(PurchaseOrder::className(), ['end_user_id' => 'id']);
        }

        /**
         * Returns user account identity related to this end user record
         *
         * @return User|null
         */
        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        /**
         * Returns country instances associated with this end user record
         *
         * @return Country
         */
        public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id_countries' => 'country_id']);
        }

        /**
         * Creates end user record and registers related to it user account,
         * which can be used to login into the system
         *
         * @return bool
         */
        public function registerEndUser()
        {
            if ($this->validate()) {
                $user = new User();
                $user->email = $this->email;
                $user->first_name = $this->title;
                $user->password = Yii::$app->security->generateRandomString(8);
                $user->password_repeat = $user->password;
                $user->roleField = User::ROLE_END_USER;

                if ($user->registerAccount()) {
                    $this->user_id = $user->id;
                    if ($this->save()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if (is_array($user->errors)) {
                        foreach ($user->errors as $attribute => $error) {
                            $this->addError($attribute, $error[0]);
                        }
                    }

                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Updates end-user record. For now without touching associated user-account
         * @return bool
         */
        public function updateEndUser()
        {
            return $this->save();
        }

    }
