<?php


    use app\models\Country;
    use app\models\Payment;
    use app\models\PurchaseOrder;
    use app\models\System;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model Payment */

    $this->title = Yii::t('app', 'Add Payment');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin([
        'id' => 'payment-create-form'
    ]); ?>

    <?=
        $form->field($model, 'po_num')
            ->dropDownList(['' => Yii::t('app', 'Select order number...')] + ArrayHelper::map(PurchaseOrder::find()->all(), 'po_num', 'po_num')) ?>

    <?= $form->field($model, 'periods')->textInput() ?>

    <?=
        $form->field($model, 'currency_code')
            ->dropDownList(['' => Yii::t('app', 'Select currency...')] + ArrayHelper::map(Country::find()->all(), 'currency_code', 'currency_code')) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?=
        $form->field($model, 'from')->radioList(
            [
                Payment::FROM_DISTR => Yii::t('app', 'Distributor'),
                Payment::FROM_USER  => Yii::t('app', 'End-User'),
            ])
    ?>

    <?= Html::activeHiddenInput($model, 'method', ['value' => Payment::METHOD_MANUAL]) ?>

    <?= $form->field($model, 'payer_email')->textInput() ?>

    <?= $form->field($model, 'transaction_id')->textInput() ?>

    <?= $form->field($model, 'payer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Add Payment'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>