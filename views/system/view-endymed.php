<?php

    use app\models\PurchaseOrder;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $po app\models\PurchaseOrder */

    $this->title = "System #" . $model->sn . " management";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="systems-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!isset($po)) : ?>
            <?= Html::a(Yii::t('app', 'Assign to PO'), ['assign', 'system_sn' => $model->sn], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (isset($po)) : ?>
            <?= Html::a(Yii::t('app', 'Unassign from PO'), ['unassign', 'system_sn' => $model->sn], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Edit PO details'), ['purchase-order/update', 'id' => $po->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Purchase Code'), ['payment/request-code', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Add Payment'), ['payment/create', 'system_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

    <div class="well">
        <?=
            DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'sn',
                    'status',
                    'login_code',
                    'current_code',
                    'next_lock_date',
                    [
                        'label' => Yii::t('app', 'Email'),
                        'value' => isset($po) ? $po->email : Yii::t('app', 'Email is not set'),
                    ],
                    'created_at'
                ],
            ]) ?>
    </div>

    <?php if (isset($po)): ?>
        <h3><?= Yii::t('app', 'Customer monetary details') ?> </h3>
        <?=
    DetailView::widget([
        'model'      => $po,
        'attributes' => [
            'po_num',
            'csp',
            'cpup',
            'nop',
            'ctpl',
            'cmp',
            'npl'
        ],
    ]) ?>

        <h3><?= Yii::t('app', 'Distributor monetary details') ?> </h3>
        <?=
        DetailView::widget([
            'model'      => $po,
            'attributes' => [
                'po_num',
                'dsp',
                'dpup',
                'nop',
                'dtpl',
                'dmp',
                'npl'
            ],
        ]) ?>
    <?php endif; ?>

</div>
