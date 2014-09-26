<?php

    use app\models\PurchaseOrder;
    use app\widgets\PpdDetailView;
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
        <?php if (($po->dtpl > 0) || ($po->ctpl > 0)) : ?>
            <?= Html::a(Yii::t('app', 'Add Payment'), ['payment/paypal-payment', 'access_token' => $model->access_token], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if ($po->dtpl > 0) : ?>
            <?= PpdDetailView::widget([
                'model'      => $po,
                'attributes' => [
                    [
                        'label' => Yii::t('app', 'Debt To Endymed For This System'),
                        'value' => $po->dtpl . ' ' . $po->currency_code,
                    ],
                    [
                        'label' => Yii::t('app', 'Left number of payments'),
                        'value' => $po->dnpl,
                    ],
                    [
                        'label' => Yii::t('app', 'Monthly payment'),
                        'value' => $po->dmp . ' ' . $po->currency_code,
                    ],
                ]
            ]) ?>
        <?php endif; ?>
        <?php if ($po->dtpl <= 0) : ?>

    <h3 class="text-center"> <?= Yii::t('app', 'Main Unlock Code: {main_code}', ['main_code' => $model->main_unlock_code]) ?> </h3>
    <?php endif; ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

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

</div>
