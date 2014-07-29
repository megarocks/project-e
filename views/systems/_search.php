<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\SystemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="systems-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sn') ?>

    <?= $form->field($model, 'po') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cpup') ?>

    <?php // echo $form->field($model, 'epup') ?>

    <?php // echo $form->field($model, 'esp') ?>

    <?php // echo $form->field($model, 'csp') ?>

    <?php // echo $form->field($model, 'nop') ?>

    <?php // echo $form->field($model, 'cmp') ?>

    <?php // echo $form->field($model, 'emp') ?>

    <?php // echo $form->field($model, 'dmp') ?>

    <?php // echo $form->field($model, 'npl') ?>

    <?php // echo $form->field($model, 'ctpl') ?>

    <?php // echo $form->field($model, 'etpl') ?>

    <?php // echo $form->field($model, 'dtpl') ?>

    <?php // echo $form->field($model, 'current_code') ?>

    <?php // echo $form->field($model, 'next_lock_date') ?>

    <?php // echo $form->field($model, 'main_unlock_code') ?>

    <?php // echo $form->field($model, 'end_user_id') ?>

    <?php // echo $form->field($model, 'distributor_id') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
