<?php
    use app\models\User;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /**@var $user User */
    $loginUrl = Url::toRoute('/site/login', true);
?>

<p>Dear <?= $user->first_name ?>,</p>

<p><?= Yii::t('app', 'Your account on EndyMed PPD program assistance website have been created') ?></p>
<p><?= Yii::t('app', 'You can start using it after login with following credentials:') ?></p>
<p>
<ul>
    <li><?= Yii::t('app', 'Login form: ') ?><?= Html::a($loginUrl, $loginUrl) ?> </li>
    <li><?= Yii::t('app', 'Username: ') ?><?= $user->email ?> </li>
    <li><?= Yii::t('app', 'Password: ') ?><?= $user->password ?> </li>
</ul>
</p>

<p><?= Yii::t('app', 'You`ll be able to change password after login') ?></p>
<p><?= Yii::t('app', 'Have a good day and don`t forget to smile') ?></p>