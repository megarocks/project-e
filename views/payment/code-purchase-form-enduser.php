<?php

    use app\models\CodeRequestForm;
    use app\models\Payment;
    use app\models\System;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model CodeRequestForm */
    /* @var $system System */

    $this->title = Yii::t('app', 'Purchase Code');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System #') . $system->sn, 'url' => ['system/' . $system->id]];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin([
        'id' => 'code-request-form'
    ]); ?>

    <?= $form->field($model, 'system_sn')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'order_num')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'periods_qty')->dropDownList(ArrayHelper::map($system->lockingDates, 'periods', 'pretty_date')) ?>

    <?= $form->field($model, 'payment_from')->hiddenInput(['value' => Payment::FROM_USER])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Proceed'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>