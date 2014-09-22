<?php

    use app\models\PurchaseOrder;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $po app\models\PurchaseOrder */

    $po = $model->purchaseOrder;

    $this->title = "System #" . $model->sn . " management";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="systems-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (!isset($po)) : ?>

        <?php endif; ?>
        <!--For now Distributor without capability of adding payment manually. Uncomment following to allow it and add rbac rule:-->
        <!--        <?php /*if (isset($po) && ($po->dtpl <= 0)) : //if distributor has no debt to endymed - he will see this area */ ?>
            <? /*= Html::a(Yii::t('app', 'Add Payment'), ['payment/create', 'system_id' => $model->id], ['class' => 'btn btn-primary']) */ ?>
        --><?php /*endif; */ ?>
        <?php if (isset($po) && ($po->dtpl > 0)) : //if distributor HAS debt to endymed - he will see this area ?>
            <?= Html::a(Yii::t('app', 'Purchase Code'), ['payment/purchase-code', 'system_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

    <div class="well">
        <?php

            $systemDetailsAttributes = [
                'sn',
                [
                    'label' => Yii::t('app', 'Status'),
                    'value' => $model->toArray(['status'])['status'],
                ],
                'login_code',
                'main_unlock_code',
                'current_code',
                'init_lock_date',
                [
                    'label' => Yii::t('app', 'Email'),
                    'value' => isset($po) ? $po->email : Yii::t('app', 'Email is not set'),
                ],
                'created_at'
            ];

            //do not show main unlock code while distributor have debt
            if (isset($po) && $po->dtpl > 0) {
                unset($systemDetailsAttributes[3]);
            }

            echo PpdDetailView::widget([
                'model'      => $model,
                'attributes' => $systemDetailsAttributes,
            ]) ?>
    </div>

    <?php if (isset($po)): ?>
        <h3><?= Yii::t('app', 'Customer monetary details') ?> </h3>
        <?=
    PpdDetailView::widget([
        'model'      => $po,
        'attributes' => [
            'po_num',
            'csp',
            'cpup',
            'nop',
            'cnpl',
            'ctpl',
            'cmp',
        ],
    ]) ?>

        <h3><?= Yii::t('app', 'Distributor monetary details') ?> </h3>
        <?=
        PpdDetailView::widget([
            'model'      => $po,
            'attributes' => [
                'po_num',
                'dsp',
                'dpup',
                'nop',
                'dnpl',
                'dtpl',
                'dmp',
            ],
        ]) ?>
    <?php endif; ?>

</div>
