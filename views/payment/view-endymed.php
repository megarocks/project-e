<?php

    use app\models\Payment;
    use app\models\System;

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
        <?= Html::a(Yii::t('app', 'View System Details'), 'system/' . $system->id, ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'View Order Details'), 'purchase-order/' . $model->purchaseOrder->id, ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="well">
        <?=
            DetailView::widget([
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
                    'created_at',
                ]
            ])
        ?>
    </div>
</div>