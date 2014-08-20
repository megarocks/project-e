<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

    $form = ActiveForm::begin([
        'id'          => 'code-login-form',
        'action'      => '/site/login?initForm=credentials',
        'options'     => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-offset-4 col-lg-1 control-label'],
        ],
    ]); ?>

<?= $form->field($model, 'email')->textInput(['type' => 'email', 'placeholder' => Yii::t('app', 'Enter Email')]) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Enter Password')]) ?>


<div class="col-lg-offset-6">
    <?= Html::a(Yii::t('app', 'Forgot Password') . '?', 'site/forgot-password') ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
</div>
<div class="form-group">
    <div class="col-lg-offset-6 col-lg-2">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<div class="col-lg-offset-5 col-sm-2">

</div>
