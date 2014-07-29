<?php

use app\models\Distributors;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Systems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'po')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'status')->dropDownList(['unlocked' => 'Unlocked', 'active' => 'Active locking no payment', 'active_payment' => 'Active locking payment',], ['prompt' => 'Select locking type...']) ?>

    <?= $form->field($model, 'cpup')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'epup')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'esp')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'csp')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'nop')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= '<label>Next Locking Date</label>'; ?>
        <?=
        DatePicker::widget([
            'name' => 'System[next_lock_date]',
            'value' => date('d-M-Y', strtotime('+2 days')),
            'options' => ['placeholder' => 'Select next locking ...'],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true
            ]
        ]); ?>


    </div>

    <?= $form->field($model, 'distributor_id')->dropDownList(ArrayHelper::map(Distributors::find()->all(), 'id', 'first_name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
