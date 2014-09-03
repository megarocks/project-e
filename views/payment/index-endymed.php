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
            <th><?= Yii::t('app', 'Added At') ?></th>
            <th><?= Yii::t('app', 'PO#') ?></th>
            <th><?= Yii::t('app', 'Payed Periods') ?></th>
            <th><?= Yii::t('app', 'Payed Amount') ?></th>
            <th><?= Yii::t('app', 'Currency') ?></th>
            <th><?= Yii::t('app', 'Payer Email') ?></th>
            <th><?= Yii::t('app', 'Payment Method') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>
