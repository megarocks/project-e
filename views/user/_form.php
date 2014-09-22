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

    <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
    <input style="display:none" type="text" name="fakeusernameremembered"/>
    <input style="display:none" type="password" name="fakepasswordremembered"/>

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($model, 'roleField')->dropDownList([
            User::ROLE_ENDY     => Yii::t('app', 'Endymed User'),
            User::ROLE_DISTR    => Yii::t('app', 'Distributor'),
            User::ROLE_SALES    => Yii::t('app', 'Sales'),
            User::ROLE_MAN      => Yii::t('app', 'Manufacturer'),
            User::ROLE_END_USER => Yii::t('app', 'End-User'),
        ]) ?>
    <?= $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t('app', 'User first name')]) ?>
    <?= $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t('app', 'User last name')]) ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'User email (can be used also as a username for login)')]) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'User password')]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'Repeat password')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>