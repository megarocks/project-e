<?php

    namespace app\models;

    use app\models\behaviors\DateTimeStampBehavior;
    use Yii;
    use yii\db\ActiveRecord;
    use yii\web\IdentityInterface;

    /**
     * This is the model class for table "users".
     *
     * @property integer $id
     * @property string $first_name
     * @property string $last_name
     * @property string $email
     * @property string $password_hash
     * @property string $password_reset_token
     * @property string $access_token
     * @property string $auth_key
     * @property string $created_at
     * @property string $updated_at
     * @property string $role
     * @property string $roleField
     *
     *
     * @property string $password
     * @property string $password_repeat
     * @property PpdBaseModel|string $relatedUserEntity
     *
     */
    class User extends PpdBaseModel implements IdentityInterface
    {
        const ROLE_SALES = 'sales';
        const ROLE_MAN = 'manufacturer';
        const ROLE_ENDY = 'endymed';
        const ROLE_DISTR = 'distributor';
        const ROLE_END_USER = 'enduser';

        public $password;
        public $password_repeat;
        private $_roleField;


        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'users';
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
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['first_name', 'email', 'roleField'], 'required'],
                [['email'], 'unique'],
                [['email'], 'email'],
                [['created_at', 'updated_at', 'password', 'password_repeat', 'roleField'], 'safe'],
                [['first_name', 'last_name', 'email'],
                    'string', 'max' => 45
                ],
                [['password_hash', 'password_reset_token', 'access_token', 'auth_key'],
                    'string', 'max' => 128
                ],
                [['password'],
                    'compare',
                    'compareAttribute' => 'password_repeat',
                ],
                [['password', 'password_repeat'],
                    'string',
                    'min' => 3,
                    'on'  => ['create'],
                ],
                [['password', 'password_repeat'],
                    'required',
                    'on' => ['create'],
                ],
                [['password', 'password_repeat'],
                    'string',
                    'min'         => 3,
                    'on'          => ['update'],
                    'skipOnEmpty' => true,
                ],
            ];
        }

        public function fields()
        {
            return array(
                'id', 'first_name', 'last_name', 'email',
                'role'       => function () {
                        switch ($this->role) {
                            case static::ROLE_DISTR:
                                return Yii::t('app', 'Distributor');
                            case static::ROLE_SALES:
                                return Yii::t('app', 'Sales');
                            case static::ROLE_END_USER:
                                return Yii::t('app', 'End-User');
                            case static::ROLE_MAN:
                                return Yii::t('app', 'Manufacturer');
                            case static::ROLE_ENDY:
                                return Yii::t('app', 'Administrator');
                            default:
                                return Yii::t('app', 'Unknown Role');
                                break;
                        }
                    },
                'created_at' => function () {
                        return date('M j Y h:i A', strtotime($this->created_at));
                    },
                'updated_at' => function () {
                        return (!is_null($this->updated_at)) ? date('M j Y h:i A', strtotime($this->updated_at)) : null;
                    }
            );
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'                   => 'ID',
                'first_name'           => Yii::t('app', 'First Name'),
                'last_name'            => Yii::t('app', 'Last Name'),
                'email'                => Yii::t('app', 'Email'),
                'password_hash'        => Yii::t('app', 'Password Hash'),
                'password_reset_token' => Yii::t('app', 'Password Reset Token'),
                'access_token'         => Yii::t('app', 'Access Token'),
                'auth_key'             => Yii::t('app', 'Auth Key'),
                'created_at'           => Yii::t('app', 'Created At'),
                'updated_at'           => Yii::t('app', 'Updated At'),
                'password'             => Yii::t('app', 'Password'),
                'password_repeat'      => Yii::t('app', 'Repeat Password'),
                'roleField'            => Yii::t('app', 'Role'),

            ];
        }

        /**
         * Finds an identity by the given ID.
         * @param string|integer $id the ID to be looked for
         * @return IdentityInterface the identity object that matches the given ID.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         */
        public static function findIdentity($id)
        {
            return static::findOne($id);
        }

        /**
         * Finds an identity by the given token.
         * @param mixed $token the token to be looked for
         * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
         * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
         * @return IdentityInterface the identity object that matches the given token.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
            return static::findOne(['access_token' => $token]);
        }

        /**
         * Returns an ID that can uniquely identify a user identity.
         * @return string|integer an ID that uniquely identifies a user identity.
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Returns a key that can be used to check the validity of a given identity ID.
         *
         * The key should be unique for each individual user, and should be persistent
         * so that it can be used to check the validity of the user identity.
         *
         * The space of such keys should be big enough to defeat potential identity attacks.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         * @return string a key that is used to check the validity of a given identity ID.
         * @see validateAuthKey()
         */
        public function getAuthKey()
        {
            return $this->auth_key;
        }

        /**
         * Validates the given auth key.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         * @param string $authKey the given auth key
         * @return boolean whether the given auth key is valid.
         * @see getAuthKey()
         */
        public function validateAuthKey($authKey)
        {
            return $this->auth_key == $authKey;
        }

        /**
         * Finds and returns user identity by given email
         * @param $email
         * @return User|null
         */
        public static function findByEmail($email)
        {
            return static::findOne(['email' => $email]);
        }

        /**
         * Method returns user identity which can be used as common for viewing system by it's code
         * Currently it always returns user with id=6
         *
         * @param string $loginCode
         * @return User
         */
        public static function findForCodeLogin($loginCode)
        {
            $system = System::getByLoginCode($loginCode);
            if ($system) {
                $endUser = $system->purchaseOrder->endUser;
                $user = $endUser->user;

                return $user;
            } else {
                return null;
            }
        }

        /**
         * Validates password
         * @param $password
         * @return bool
         */
        public function validatePassword($password)
        {
            return Yii::$app->security->validatePassword($password, $this->password_hash);
        }

        /**
         * Checks if user have role
         * @param $role string
         * @return bool
         */
        public function hasRole($role)
        {
            $userRoles = Yii::$app->authManager->getRolesByUser($this->id);

            return array_key_exists($role, $userRoles);
        }

        /**
         * Returns user role. Currently it returns first role assigned to user
         * By the Yii RBAC system user can have more than one role
         *
         * @return string|null
         */
        public function getRole()
        {
            $userRoles = Yii::$app->authManager->getRolesByUser($this->id);

            return isset(array_keys($userRoles)[0]) ? array_keys($userRoles)[0] : null; //TODO Unhardcode only one role (when/if will be needed)
        }

        public function setRole($value)
        {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($value);
            if (!is_null($role) && $this->id) {
                $auth->revokeAll($this->id);
                $auth->assign($role, $this->id);
            }
        }

        public function getRoleField()
        {
            if (!is_null($this->role)) {
                return $this->role;
            } else {
                return $this->_roleField;
            }

        }

        public function setRoleField($value)
        {
            $this->_roleField = $value;
        }

        /**
         * Checks if supplied login code is valid
         *
         * @param $loginCode
         * @return boolean
         */
        public function validateLoginCode($loginCode)
        {
            $system = System::findOne(['login_code' => $loginCode]);

            return !is_null($system) ? true : false;
        }

        public static function findByPasswordResetToken($token)
        {
            return $user = static::findOne(['password_reset_token' => $token]);
        }

        public function regeneratePasswordResetToken()
        {
            $this->password_reset_token = Yii::$app->security->generateRandomString();
            $this->save();
        }

        public function getRelatedUserEntity()
        {
            switch ($this->role) {
                case static::ROLE_DISTR:
                    return $this->hasOne(Distributor::className(), ['user_id' => 'id']);
                    break;
                case static::ROLE_MAN:
                    return $this->hasOne(Manufacturer::className(), ['user_id' => 'id']);
                    break;
                case static::ROLE_END_USER:
                    return $this->hasOne(EndUser::className(), ['user_id' => 'id']);
                    break;
                case static::ROLE_SALES:
                    return $this->hasOne(SalesUser::className(), ['user_id' => 'id']);
                    break;
                default:
                    return static::ROLE_ENDY;
                    break;
            }
        }

        /**
         * @return boolean
         */
        public function createModel()
        {
            $this->scenario = 'create';
            if ($this->validate()) {

                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->password_reset_token = Yii::$app->security->generateRandomString();
                $this->access_token = Yii::$app->security->generateRandomString();

                if ($this->save()) {

                    $this->role = $this->_roleField;

                    Yii::$app->mailer->compose('user/user-account-created', ['user' => $this])
                        ->setFrom('noreply@projecte.com')
                        ->setTo($this->email)
                        ->setSubject(Yii::t('app', 'EndyMed PPD account'))
                        ->send();

                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * @return boolean
         */
        public function updateModel()
        {
            $this->scenario = 'update';
            if ($this->validate()) {
                if (!is_null($this->password) && !empty($this->password)) {
                    $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                }
                $this->role = $this->_roleField;

                if ($this->save()) {
                    Yii::$app->mailer->compose('user/user-account-updated', ['user' => $this])
                        ->setFrom('noreply@projecte.com')
                        ->setTo($this->email)
                        ->setSubject(Yii::t('app', 'EndyMed PPD account'))
                        ->send();

                    return true;
                } else {
                    return false;
                }
            }
        }

        /**
         * @return boolean
         */
        public function deleteModel()
        {
            $relatedEntityDeleteResult = false;
            $mainUserEntityDeleteResult = false;
            if ($this->relatedUserEntity) {
                if ($this->relatedUserEntity == static::ROLE_ENDY) {
                    $relatedEntityDeleteResult = true;
                } else {
                    $relatedEntityDeleteResult = $this->relatedUserEntity->deleteModel(false);
                }
            }

            if ($relatedEntityDeleteResult) {
                $mainUserEntityDeleteResult = $this->delete();
            }

            return $relatedEntityDeleteResult && $mainUserEntityDeleteResult;
        }
    }
