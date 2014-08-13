<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;

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
                $user = $this->getUser();

                if (!$user || !$user->validateCode($this->loginCode)) {
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
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
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
                $this->_user = User::findByLoginCode($this->loginCode);
            }

            return $this->_user;
        }
    }
