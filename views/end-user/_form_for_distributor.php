<?php

    use app\models\Country;
    use app\models\Distributor;
    use kartik\widgets\DepDrop;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $endUser app\models\EndUser */
    /* @var $relatedUser app\models\User */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $countriesList array */

?>

<div class="end-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($endUser, 'country_id')->hiddenInput()->label(false);
    ?>

    <?=
        $form->field($endUser, 'distributor_id')->hiddenInput()->label(false);
    ?>

    <?= $form->field($relatedUser, 'first_name')->textInput(['maxlength' => 45])->label(Yii::t('app', 'Title/First Name')) ?>
    <?= $form->field($relatedUser, 'roleField')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'email')->textInput() ?>

    <?= $form->field($endUser, 'phone')->textInput() ?>
    <?= $form->field($endUser, 'contact_person')->textInput() ?>

    <?= $form->field($relatedUser, 'password')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'password_repeat')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($endUser->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $endUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
