<?php

    use app\models\Country;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $distributor app\models\Distributor */
    /* @var $relatedUser app\models\User */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="distributors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($distributor, 'country_id')->dropDownList(
            ['' => Yii::t('app', 'Select Country...')] +
            ArrayHelper::map(Country::find()->all(), 'id', 'name')
        )
    ?>

    <?= $form->field($relatedUser, 'first_name')->textInput(['maxlength' => 45])->label(Yii::t('app', 'Title/First Name')) ?>
    <?= $form->field($relatedUser, 'roleField')->hiddenInput()->label(false) ?>

    <?= $form->field($relatedUser, 'email')->textInput() ?>
    <?= $form->field($distributor, 'phone')->textInput() ?>
    <?= $form->field($distributor, 'contact_person')->textInput() ?>

    <?= $form->field($relatedUser, 'password')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'password_repeat')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($distributor->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $distributor->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
