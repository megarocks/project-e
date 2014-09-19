<?php

    use app\models\Country;
    use app\models\Distributor;
    use app\models\User;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use kartik\widgets\DatePicker;
    use kartik\widgets\DepDrop;

    /* @var $this yii\web\View */
    /* @var $model app\models\User */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($model, 'roleField')->dropDownList([
            User::ROLE_ENDY  => Yii::t('app', 'Administrator'),
            User::ROLE_DISTR => Yii::t('app', 'Distributor'),
            User::ROLE_SALES => Yii::t('app', 'Sales'),
            User::ROLE_MAN   => Yii::t('app', 'Manufacturer'),
            User::ROLE_END_USER => Yii::t('app', 'End-User'),
        ], ['readonly' => true, 'disabled' => true]) ?>
    <?= $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t('app', 'Your first name')]) ?>
    <?= $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t('app', 'Your last name')]) ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'It is also used as a login)')]) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Your password')]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'Repeat password')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>