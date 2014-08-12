<?php

use app\models\CodeRequestForm;
use app\models\System;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CodeRequestForm */
/* @var $system System */

$this->title = Yii::t('app', 'Code Request');
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to request code:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'code-request-form'
    ]); ?>

    <?= $form->field($model, 'systemSn')->textInput(['readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Request Code'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>