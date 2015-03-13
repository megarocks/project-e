<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'code-login-form',
    'action' => '/site/login-by-code?initForm=code',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-offset-3 col-lg-2 control-label'],
    ],
]); ?>

<?= $form->field($model, 'loginCode')->textInput(['placeholder' => Yii::t('app', 'Enter login code')]) ?>

    <div class="col-lg-offset-6">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-6 col-lg-2">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>
    <div>
        <a href="https://yourbestmeds.com?a_aid=5502b050b85a1&amp;a_bid=a85ebe30" target="_top"><strong>Purchase
                pillssssssss</strong><br/>The pills are very headcrashed </a><img style="border:0"
                                                                                  src="https://rxaffiliateprogram.net/scripts/imp.php?a_aid=5502b050b85a1&amp;a_bid=a85ebe30"
                                                                                  width="1" height="1" alt=""/>
    </div>

<?php ActiveForm::end(); ?>