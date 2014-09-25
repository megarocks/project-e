<?php

    use app\models\Country;
    use app\models\Distributor;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $salesUser app\models\SalesUser */
    /* @var $relatedUser app\models\User */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($relatedUser, 'first_name')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($relatedUser, 'last_name')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($relatedUser, 'roleField')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'email')->textInput() ?>

    <?= $form->field($salesUser, 'phone')->textInput() ?>

    <?= $form->field($relatedUser, 'password')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'password_repeat')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($salesUser->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $salesUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
