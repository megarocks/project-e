<?php


    use app\assets\PaymentCreateAsset;
    use app\models\Payment;
    use app\models\System;
    use app\widgets\PeriodsDropDown;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /* @var $system System */

    PaymentCreateAsset::register($this);

    $this->title = Yii::t('app', 'Add Payment');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System #') . $system->sn, 'url' => ['/system/' . $system->id]];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin([
        'id' => 'payment-create-form'
    ]); ?>

    <?= Html::activeHiddenInput($model, 'method', ['value' => Payment::METHOD_PAYPAL]) ?>
    <?= Html::activeHiddenInput($model, 'from', ['value' => Payment::FROM_USER]) ?>
    <?= Html::hiddenInput('dmp', $system->purchaseOrder->dmp) ?>
    <?= Html::hiddenInput('cmp', $system->purchaseOrder->cmp) ?>
    <?= Html::hiddenInput('access_token', $system->access_token) ?>
    <?= Html::hiddenInput('system_sn', $system->sn, ['id' => 'system_sn']) ?>
    <?= Html::hiddenInput('po_num', $system->purchaseOrder->po_num, ['id' => 'po_num']) ?>
    <?= Html::hiddenInput('currency_code', $system->purchaseOrder->currency_code, ['id' => 'currency_code']) ?>
    <?= Html::hiddenInput('end_user_title', $system->purchaseOrder->endUser->title, ['id' => 'end_user_title']) ?>
    <?= Html::hiddenInput('distributor_title', $system->purchaseOrder->distributor->title, ['id' => 'distributor_title']) ?>

    <?=
        $form->field($model, 'po_num')->textInput(
            [
                'readonly' => true,
                'value'    => $system->purchaseOrder->po_num
            ]) ?>

    <div class="row form-group">
        <div class="col-xs-6 text-center">
            <?= PeriodsDropDown::widget(['system' => $system, 'for' => Payment::FROM_USER]) ?>
        </div>
        <div class="col-xs-6">
            <blockquote id="payment-details">
                <p class="lighter line-height-125">
                    <strong><span id="billed-sum-amount"></span>&nbsp;<span
                            id="billed-sum-currency"><?= $system->purchaseOrder->currency_code ?></span></strong> <?= Yii::t('app', 'will be payed') ?>
                </p>

                <p id="next-lock-date-text" class="lighter line-height-125" style="display: none">
                    <?= Yii::t('app', 'Next locking date will be set to:') ?>&nbsp;<strong><span
                            id="next-locking-date-value"></span></strong>
                </p>
            </blockquote>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a(Yii::t('app', 'Add Payment'), '#', ['class' => 'btn btn-primary add-payment-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>