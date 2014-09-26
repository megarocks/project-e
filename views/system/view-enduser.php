<?php

    use app\models\PurchaseOrder;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /**@var PurchaseOrder $po */
    $po = $model->purchaseOrder;

    $this->title = Yii::t('app', 'System Details');
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="systems-view">
    <p>
        <?php if ($po->ctpl > 0) : ?>
            <?= Html::a(Yii::t('app', 'Add Payment'), ['payment/paypal-payment', 'access_token' => $model->access_token], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if ($po->ctpl <= 0) : ?>

    <h3 class="text-center"> <?= Yii::t('app', 'Main Unlock Code: {main_code}', ['main_code' => $model->main_unlock_code]) ?> </h3>
    <?php endif; ?>
    </p>

    <div class="well">
        <?=
            PpdDetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'sn',
                    'systemStatus',
                    'login_code',
                    'current_code',
                    'initialLockingDate',
                    'nextLockingDate',
                    'createdAt',
                ],
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
