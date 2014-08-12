<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * CodeRequestForm is the model behind the code request form.
 */
class CodeRequestForm extends Model
{
    public $systemSn;
    public $nextLockDate;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['systemSn', 'nextLockDate'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'systemSn' => Yii::t('app', 'System SN'),
            'nextLockDate' => Yii::t('app', 'Next Locking Date'),
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
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

}
