<?php

    namespace app\models;

    use Yii;
    use yii\base\Exception;
    use yii\base\Model;
    use yii\log\Logger;

    /**
     * ForgotPasswordForm is the model behind the password remind form
     *
     * @property string $email
     */
    class ForgotPasswordForm extends Model
    {
        public $email;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                [['email'], 'required'],
                [['email'], 'email'],
                [['email'], 'validateEmail'],

            ];
        }

        /**
         * Validates the email.
         * This method serves as the inline validation for email.
         * Will check does provided email is registered in the application
         */
        public function validateEmail()
        {
            if (!$this->hasErrors()) {
                $user = User::findByEmail($this->email);

                if (!$user) {
                    $this->addError('email', Yii::t('app', 'User with such email is not registered'));
                }
            }
        }

        /**
         * Send user an email with password restoring link
         * @return boolean whether the user is logged in successfully
         */
        public function sendMailWithLink()
        {
            if ($this->validate()) {
                Yii::getLogger()->log([
                    'Action'       => 'User asked to remind password',
                    'Email'        => $this->email,
                    'Remote IP'    => $_SERVER['REMOTE_ADDR'],
                    'Behind Proxy' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'No proxy',
                ], Logger::LEVEL_WARNING, 'login');
                $user = User::findByEmail($this->email);

                if
                (
                Yii::$app->mailer->compose('site/forgot-password', ['user' => $user])
                    ->setFrom('noreply@projecte.com')
                    ->setTo($user->email)
                    ->setSubject(Yii::t('app', 'EndyMed PPD password remind'))
                    ->send()
                ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
