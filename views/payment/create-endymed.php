<?php


    use app\models\Country;
    use app\models\Payment;
    use app\models\System;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /* @var $system System */


    $this->title = Yii::t('app', 'Add Payment');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System #') . $system->sn, 'url' => ['system/' . $system->id]];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin([
        'id' => 'payment-create-form'
    ]); ?>

    <?=
        $form->field($model, 'po_num')->textInput(
            [
                'readonly' => true,
                'value'    => $system->purchaseOrder->po_num
            ]) ?>
    <?= $form->field($model, 'transaction_id')->textInput() ?>
    <?= $form->field($model, 'payer_id')->textInput() ?>
    <?= $form->field($model, 'payer_email')->textInput(['value' => $system->purchaseOrder->email]) ?>
    <?=
        $form->field($model, 'periods')
            ->dropDownList(ArrayHelper::map($system->lockingDates, 'periods', 'pretty_date'))
            ->label(Yii::t('app', 'Periods to unlock')) ?>
    <?= $form->field($model, 'amount')->textInput()->label(Yii::t('app', 'Amount') . ' (' . $system->purchaseOrder->currency_code . ')') ?>
    <?=
        $form->field($model, 'from')->radioList(
            [
                Payment::FROM_DISTR => Yii::t('app', 'Distributor'),
                Payment::FROM_USER  => Yii::t('app', 'End-User'),
            ]) ?>
    <?= Html::activeHiddenInput($model, 'method', ['value' => Payment::METHOD_MANUAL]) ?>
    <?= Html::activeHiddenInput($model, 'currency_code', ['value' => $system->purchaseOrder->currency_code]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Add Payment'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>