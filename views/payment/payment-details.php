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
        <?= Html::a(Yii::t('app', 'Go to system details'), 'system/view-by-code', ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="well">
        <?=
            DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'id',
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
                    [
                        'label' => Yii::t('app', 'New unlock code'),
                        'value' => $system->current_code
                    ],
                    [
                        'label' => Yii::t('app', 'Next locking date'),
                        'value' => $system->next_lock_date
                    ],
                ]
            ])
        ?>
    </div>
</div>