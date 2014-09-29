<?php

    use app\models\Payment;
    use app\models\System;

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /**@var $system System */

    $this->title = "Payment #" . $model->id . " details";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    $system = $model->purchaseOrder->system;
?>

<div class="payment-details">
    <p>
        <?php if (isset($model->purchaseOrder) && isset($model->purchaseOrder->system)) : ?>
            <?= Html::a(Yii::t('app', 'View System Details'), '/system/' . $system->id, ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'View Order Details'), '/purchase-order/' . $model->purchaseOrder->id, ['class' => 'btn btn-primary']) ?>
        <?php endif ?>
    </p>

    <div class="well">
        <?=
            PpdDetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'po_num',
                    [
                        'label' => Yii::t('app', 'System SN'),
                        'value' => $system->sn
                    ],
                    'periods',
                    [
                        'label' => Yii::t('app', 'Payed amount'),
                        'value' => $model->amount . ' ' . $model->currency_code
                    ],
                    'payer_email:email',
                    'from',
                    'method',
                    'createdAt',
                ]
            ])
        ?>
    </div>
</div>