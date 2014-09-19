<?php

    use app\models\Payment;
    use app\models\System;

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model Payment */
    /**@var $system System */
    $system = $model->purchaseOrder->system;

    $this->title = Yii::t('app', 'Payment Details');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System details'), 'url' => ['/system/' . $system->id]];
    $this->params['breadcrumbs'][] = $this->title;

?>

<div class="payment-details">
    <p>
        <?= Html::a(Yii::t('app', 'View System Details'), '/system/' . $system->id, ['class' => 'btn btn-primary']) ?>
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
                    'method',
                    [
                        'label' => Yii::t('app', 'Payment Date/Time'),
                        'value' => date('M d, Y h:i A', strtotime($model->created_at))
                    ]
                ]
            ])
        ?>
    </div>
</div>