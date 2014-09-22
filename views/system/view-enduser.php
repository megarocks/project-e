<?php

    use app\models\PurchaseOrder;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /**@var PurchaseOrder $po */

    $this->title = Yii::t('app', 'System Details');
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="systems-view">
    <p>
        <?= Html::a(Yii::t('app', 'Purchase Code'), ['payment/purchase-code', 'system_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="well">
        <?php

            $systemDetails = [
                'sn',
                [
                    'label' => Yii::t('app', 'Status'),
                    'value' => $model->toArray(['status'])['status'],
                ],
                'login_code',
                'current_code',
                'next_lock_date',
                [
                    'label' => Yii::t('app', 'Email'),
                    'value' => $model->purchaseOrder->email,
                ],
            ];

            if (isset($po) && $po->ctpl <= 0) {
                $systemDetails = [
                    'sn',
                    [
                        'label' => Yii::t('app', 'Status'),
                        'value' => $model->toArray(['status'])['status'],
                    ],
                    'main_unlock_code',
                ];
            }

            echo PpdDetailView::widget([
                'model'      => $model,
                'attributes' => $systemDetails,
            ]) ?>
    </div>

    <h3><?= Yii::t('app', 'Monetary details') ?> </h3>
    <?=
        PpdDetailView::widget([
            'model'      => $model->purchaseOrder,
            'attributes' => [
                'po_num',
                'currency_code',
                'csp',
                'cpup',
                'nop',
                'ctpl',
                'cmp',
                'cnpl',
            ],
        ]) ?>
</div>
