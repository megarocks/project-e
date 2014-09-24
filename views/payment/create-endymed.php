<?php


    use app\assets\PaymentCreateAsset;
    use app\models\Payment;
    use app\models\System;
    use app\widgets\PeriodsDropDown;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /* @var $system System */

    PaymentCreateAsset::register($this);

    $this->title = Yii::t('app', 'Add Payment');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System #') . $system->sn, 'url' => ['/system/' . $system->id]];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin([
        'id' => 'payment-create-form'
    ]); ?>

    <?= Html::activeHiddenInput($model, 'method', ['value' => Payment::METHOD_MANUAL]) ?>
    <?= Html::hiddenInput('dmp', $system->purchaseOrder->dmp) ?>
    <?= Html::hiddenInput('cmp', $system->purchaseOrder->cmp) ?>
    <?= Html::hiddenInput('access_token', $system->access_token) ?>

    <?=
        $form->field($model, 'po_num')->textInput(
            [
                'readonly' => true,
                'value'    => $system->purchaseOrder->po_num
            ]) ?>

    <?=
        $form->field($model, 'from')->radioList(
            [
                Payment::FROM_DISTR => Yii::t('app', 'Distributor'),
                Payment::FROM_USER  => Yii::t('app', 'End-User'),
            ]) ?>

    <div class="row">
        <div class="col-xs-6 text-center">
            <?= PeriodsDropDown::widget(['system' => $system, 'for' => Payment::FROM_DISTR]) ?>
        </div>
        <div class="col-xs-6">
            <blockquote>
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
        <?= Html::submitButton(Yii::t('app', 'Add Payment'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>