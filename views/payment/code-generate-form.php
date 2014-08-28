<?php

    use app\models\CodeRequestForm;
    use app\models\System;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model CodeRequestForm */
    /* @var $system System */

    $this->title = Yii::t('app', 'Code Generation');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to generate code:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'code-generate-form'
    ]); ?>

    <?= $form->field($model, 'system_sn')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'order_num')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'periods_qty')->dropDownList(ArrayHelper::map($system->lockingDates, 'periods', 'pretty_date'))->label(Yii::t('app', 'Periods to unlock')) ?>
    <?= Html::activeHiddenInput($model, 'require_payment', ['value' => 'false']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>