<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    use app\assets\PaymentEndymedAsset;

    PaymentEndymedAsset::register($this);

    /* @var $this yii\web\View */

    $this->title = Yii::t('app', 'Payments');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Add new payment'), ['add-payment'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="payments-table" class="table-hover">
        <thead>
        <tr>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this payment was added to database') ?> ">
                    <?= Yii::t('app', 'Added At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'Purchase order number') ?> ">
                    <?= Yii::t('app', 'PO#') ?>
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
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Payer contact email') ?> ">
                    <?= Yii::t('app', 'Payer email') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Payment adding method') ?> ">
                    <?= Yii::t('app', 'Payment Method') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>
