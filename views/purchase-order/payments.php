<?php

    use app\models\PurchaseOrder;
    use yii\helpers\Html;
    use yii\grid\GridView;

    use app\assets\PurchaseOrderPaymentsAsset;

    PurchaseOrderPaymentsAsset::register($this);

    /* @var $this yii\web\View */
    /* @var PurchaseOrder $order */

    $this->title = Yii::t('app', 'Payments');
    $this->params['breadcrumbs'][] = Yii::t('app', 'Purchase Order #{po_num}', ['po_num' => $order->po_num]);
    $this->params['breadcrumbs'][] = $this->title;

    echo Html::activeHiddenInput($order, 'po_num');
?>
<div class="order-payments">
    <p>
    </p>

    <table id="payments-table" class="table-hover">
        <thead>
        <tr>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this payment was added') ?> ">
                    <?= Yii::t('app', 'Added At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Purchase Order #') ?> ">
                    <?= Yii::t('app', 'PO#') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'System Serial Number') ?> ">
                    <?= Yii::t('app', 'System SN') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Number of periods covered by this payment') ?> ">
                    <?= Yii::t('app', 'Payed Periods') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Payed Amount') ?> ">
                    <?= Yii::t('app', 'Payed Amount') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Currency of payment') ?> ">
                    <?= Yii::t('app', 'Currency') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>
