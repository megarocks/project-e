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
     *
     * @property string $password
     * @property string $password_repeat
     *
     */
    class User extends ActiveRecord implements IdentityInterface
    {
        const ROLE_SALES = 'sales';
        const ROLE_PROD = 'production';
        const ROLE_ENDY = 'endymed';
        const ROLE_DISTR = 'distributor';
        const ROLE_END_USER = 'enduser';

        public $password;
        public $password_repeat;


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
                [['first_name', 'email'], 'required'],
                [['email'], 'unique'],
                [['email'], 'email'],
                [['created_at', 'updated_at', 'password', 'password_repeat'], 'safe'],
                [['first_name', 'last_name', 'email'], 'string', 'max' => 45],
                [['password_hash', 'password_reset_token', 'access_token', 'auth_key'], 'string', 'max' => 128],
                [['password'], 'compare', 'compareAttribute' => 'password_repeat', 'skipOnEmpty' => true]
            ];
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
                'password'        => Yii::t('app', 'Password'),
                'password_repeat' => Yii::t('app', 'Repeat Password'),
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
            // TODO: Implement validateAuthKey() method.
        }

        public static function findByEmail($email)
        {
            return static::findOne(['email' => $email]);
        }

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

        public function getRole()
        {
            $userRoles = Yii::$app->authManager->getRolesByUser($this->id);

            return isset(array_keys($userRoles)[0]) ? array_keys($userRoles)[0] : null; //TODO Unhardcode only one role (when/if will be needed)
        }

        public function setRole($value)
        {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($value);
            if (!is_null($role)) {
                $auth->assign($role, $this->id);
            }
        }

        public static function findForCodeLogin()
        {
            return static::findOne(6); //TODO Currently user with id=6 considered as account for code-login purposes
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
    }
