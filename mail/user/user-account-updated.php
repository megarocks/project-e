<?php
    use app\models\User;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /**@var $user User */
    $loginUrl = Url::toRoute('/site/login', true);
?>

<p>Dear <?= $user->first_name ?>,</p>

<p><?= Yii::t('app', 'Your account on EndyMed PPD program assistance website have been updated') ?></p>
<p><?= Yii::t('app', 'Here is details of your account:') ?></p>
<table
    style="border-radius: 0; border: 1px solid #ddd; width: 100%; max-width: 100%; margin-bottom: 20px; background-color: transparent; border-spacing: 0; border-collapse: collapse; display: table; border-spacing: 2px;">
    <tbody style="box-sizing: border-box; display: table-row-group; vertical-align: middle; border-color: inherit;">
    <tr>
        <th width="50%"
            style="padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; text-align: left;"><?= Yii::t('app', 'First Name') ?></th>
        <td style="border: 1px solid #ddd; padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; display: table-cell;"><?= $user->first_name ?></td>
    </tr>
    <tr>
        <th width="50%"
            style="padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; text-align: left;"><?= Yii::t('app', 'Last Name') ?></th>
        <td style="border: 1px solid #ddd; padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; display: table-cell;"><?= $user->last_name ?></td>
    </tr>
    <tr>
        <th width="50%"
            style="padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; text-align: left;"><?= Yii::t('app', 'Email') ?></th>
        <td style="border: 1px solid #ddd; padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; display: table-cell;"><?= $user->email ?></td>
    </tr>
    <tr>
        <th width="50%"
            style="padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; text-align: left;"><?= Yii::t('app', 'Login Form') ?></th>
        <td style="border: 1px solid #ddd; padding: 8px; line-height: 1.428571; vertical-align: top; border-top: 1px solid #ddd; display: table-cell;"><?= Html::a($loginUrl, $loginUrl) ?></td>
    </tr>
    </tbody>
</table>
<p><?= Yii::t('app', 'Have a good day and don`t forget to smile') ?></p>