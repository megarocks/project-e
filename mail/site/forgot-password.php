<?php
    use app\models\User;
    use yii\helpers\Html;

    /**@var $user User */
    $passwordResetUrl = \yii\helpers\Url::toRoute(['/site/password-reset', 'password_reset_token' => urlencode($user->password_reset_token)], true);
?>

<p>Dear <?= $user->first_name ?>,</p>
<p>
    <?= Yii::t('app', 'We have received a request to reset your password. To move ahead with it follow up the provided link and set new password') ?>
</p>
<p>
    <?=
        Html::a($passwordResetUrl, $passwordResetUrl);
    ?>
</p>
<p>
    <?= Yii::t('app', 'Please note that this link will became invalid after you will click it.') ?>
</p>

<p>
    <?= Yii::t('app', 'If you do not need to reset password just ignore this message or call a police') ?>
</p>

