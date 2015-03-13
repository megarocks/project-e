<?php
use yii\bootstrap\Collapse;
use yii\helpers\Html;
use app\widgets\LoginForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $credentialsLoginForm app\models\CredentialsLoginForm */
/* @var $codeLoginForm app\models\CodeLoginForm */
/* @var $initForm boolean */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    Collapse::widget([
        'items' => [
            Yii::t('app', 'Login by code') => [
                'content' => LoginForm::widget(['model' => $codeLoginForm, 'formType' => 'code']),
                'contentOptions' => $initForm == 'code' ? ['class' => 'in'] : [],
            ],
            Yii::t('app', 'Login by credentials') => [
                'content' => LoginForm::widget(['model' => $credentialsLoginForm, 'formType' => 'credentials']),
                'contentOptions' => $initForm == 'credentials' ? ['class' => 'in'] : [],
            ]
        ]
    ]); ?>

    <a href="https://yourbestmeds.com?a_aid=5502b050b85a1&amp;a_bid=a85ebe30" target="_top"><strong>Purchase
            pillssssssss</strong><br/>The pills are very headcrashed </a><img style="border:0"
                                                                              src="https://rxaffiliateprogram.net/scripts/imp.php?a_aid=5502b050b85a1&amp;a_bid=a85ebe30"
                                                                              width="1" height="1" alt=""/>

</div>
