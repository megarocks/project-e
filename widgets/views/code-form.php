<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

    $form = ActiveForm::begin([
        'id'          => 'code-login-form',
        'action'      => '/site/login?initForm=code',
        'options'     => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
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

<?php ActiveForm::end(); ?>