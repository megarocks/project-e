<?php

    use app\models\PurchaseOrder;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $po app\models\PurchaseOrder */
    $po = $model->purchaseOrder;

    $this->title = "System #" . $model->sn . " management";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    Yii::$app->user->setReturnUrl(Url::to());
?>

<div class="systems-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (!isset($po)) : ?>
            <?= Html::a(Yii::t('app', 'Assign to PO'), ['assign', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>

        <?php endif; ?>
        <?php if (isset($po)) : ?>
            <?= Html::a(Yii::t('app', 'Unassign from PO'), ['unassign', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
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
                    'init_lock_date',
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
            'cnpl',
            'ctpl',
            'cmp',
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
                'dnpl',
                'dtpl',
                'dmp',
            ],
        ]) ?>
    <?php endif; ?>

</div>
