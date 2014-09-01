<?php

    use app\models\Payment;
    use app\models\System;

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /**@var $system System */

    $this->title = "Payment #" . $model->id . " details";

    $system = $model->purchaseOrder->system;
?>

<div class="payment-details">
    <h1><?= Html::encode($this->title) ?></h1>

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