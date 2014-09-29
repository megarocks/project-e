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

    /** @var PurchaseOrder $po */
    $po = $model->purchaseOrder;
?>

<?php if ($po->ctpl > 0) : ?>
    <div class="systems-view">
        <p>
            <?= Html::a(Yii::t('app', 'Add Payment'), ['payment/paypal-payment', 'access_token' => $model->access_token], ['class' => 'btn btn-primary']) ?>
        </p>

        <h3><?= Yii::t('app', 'Monetary details') ?> </h3>
        <?=
            PpdDetailView::widget([
                'model'      => $po,
                'attributes' => [
                    [
                        'label' => Yii::t('app', 'Total cost of this system'),
                        'value' => $po->csp . ' ' . $po->currency_code,
                    ],
                    [
                        'label' => Yii::t('app', 'Monthly payment'),
                        'value' => $po->cmp . ' ' . $po->currency_code,
                    ],
                    [
                        'label' => Yii::t('app', 'Number of left payment'),
                        'value' => $po->cnpl,
                    ],
                    [
                        'label' => Yii::t('app', 'Rest amount to pay'),
                        'value' => $po->ctpl . ' ' . $po->currency_code,
                    ],
                ],
            ]) ?>
        <h3><?= Yii::t('app', 'System Technical Details') ?> </h3>

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
    </div>

<?php endif; ?>

<?php if ($po->ctpl <= 0) : ?>
    <div class="systems-view">
        <p>
            <!--TODO We can add payments list here-->

            <strong><h3
                    class="text-center"> <?= Yii::t('app', 'Main Unlock Code: {main_code}', ['main_code' => $model->main_unlock_code]) ?> </h3>
            </strong>
        </p>

        <h3><?= Yii::t('app', 'System Technical Details') ?> </h3>

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
                        'createdAt',
                    ],
                ]) ?>
        </div>

        <h3><?= Yii::t('app', 'Monetary details') ?> </h3>
        <?=
            PpdDetailView::widget([
                'model'      => $po,
                'attributes' => [
                    [
                        'label' => Yii::t('app', 'Total cost of this system'),
                        'value' => $po->csp . ' ' . $po->currency_code,
                    ],
                ],
            ]) ?>
    </div>
<?php endif; ?>

