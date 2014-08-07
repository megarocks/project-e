<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="po-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'po_num')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'cpup')->textInput() ?>
    <?= $form->field($model, 'epup')->textInput() ?>
    <?= $form->field($model, 'esp')->textInput() ?>
    <?= $form->field($model, 'csp')->textInput() ?>
    <?= $form->field($model, 'nop')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>