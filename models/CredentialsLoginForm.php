<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;
    use yii\log\Logger;

    /**
     * CredentialsLoginForm is the model behind the credentials login form.
     */
    class CredentialsLoginForm extends Model
    {
        public $email;
        public $password;
        public $rememberMe = true;

        private $_user = false;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                // username and password are both required
                [['email', 'password'], 'required'],
                // rememberMe must be a boolean value
                ['rememberMe', 'boolean'],
                // password is validated by validatePassword()
                ['password', 'validatePassword'],
            ];
        }

        /**
         * Validates the password.
         * This method serves as the inline validation for password.
         */
        public function validatePassword()
        {
            if (!$this->hasErrors()) {
                $user = $this->getUser();

                if (!$user || !$user->validatePassword($this->password)) {
                    $this->addError('password', Yii::t('app', 'Incorrect username or password'));
                }
            }
        }

        /**
         * Logs in a user using the provided username and password.
         * @return boolean whether the user is logged in successfully
         */
        public function login()
        {
            if ($this->validate()) {
                $loginResult = Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                Yii::getLogger()->log([
                    'Action'       => 'Attempt to login with credentials',
                    'User'         => $this->email,
                    'RememberMe'   => $this->rememberMe,
                    'Remote IP'    => $_SERVER['REMOTE_ADDR'],
                    'Behind Proxy' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'No proxy',
                    'Login Result' => $loginResult
                ], Logger::LEVEL_INFO, 'login');

                return $loginResult;
            } else {
                return false;
            }
        }

        /**
         * Finds user by [[username]]
         *
         * @return User|null
         */
        public function getUser()
        {
            if ($this->_user === false) {
                $this->_user = User::findByEmail($this->email);
            }

            return $this->_user;
        }
    }
