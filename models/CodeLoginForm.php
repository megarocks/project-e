<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;
    use yii\log\Logger;

    /**
     * CredentialsLoginForm is the model behind the credentials login form.
     */
    class CodeLoginForm extends Model
    {
        public $loginCode;
        public $rememberMe = true;

        private $_user = false;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                // loginCode is required
                [['loginCode'], 'required'],
                // rememberMe must be a boolean value
                ['rememberMe', 'boolean'],
                // code is validated by validateCode()
                ['loginCode', 'validateCode'],
            ];
        }

        /**
         * Validates the code.
         * This method serves as the inline validation for code.
         */
        public function validateCode()
        {
            if (!$this->hasErrors()) {
                $user = $this->getUser($this->loginCode);

                if (!$user || !$user->validateLoginCode($this->loginCode)) {
                    $this->addError('loginCode', Yii::t('app', 'Incorrect login code'));
                }
            }
        }

        /**
         * Logs in a user using the provided login code.
         * @return boolean whether the user is logged in successfully
         */
        public function login()
        {
            if ($this->validate()) {
                $loginResult = Yii::$app->user->login($this->getUser($this->loginCode), $this->rememberMe ? 3600 * 24 * 30 : 0);
                Yii::getLogger()->log([
                    'Action'       => 'Attempt to login using system code',
                    'Code'         => $this->loginCode,
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
         * Finds user for code login purposes
         *
         * @param $loginCode
         * @return User|null
         */
        public function getUser($loginCode)
        {
            if ($this->_user === false) {
                $this->_user = User::findForCodeLogin($loginCode);
            }

            return $this->_user;
        }
    }
