<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 8/6/14
     * Time: 5:17 PM
     */
    use app\assets\PoIndexSalesAsset;
    use yii\helpers\Html;

    PoIndexSalesAsset::register($this);

    $this->title = Yii::t('app', 'Purchase Orders');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-orders-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Add new purchase order', [
                'modelClass' => 'Systems',
            ]), ['create'], ['class' => 'btn btn-success btn-sm'])
        ?>
    </p>

    <table id="po-table" class="table-hover">
        <thead>
        <tr>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this order was added to database') ?> ">
                    <?= Yii::t('app', 'Added At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'Purchase order number') ?> ">
                    <?= Yii::t('app', 'PO#') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'System serial number') ?> ">
                    <?= Yii::t('app', 'System SN') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'The remaining amount that the customer must pay') ?> ">
                    <?= Yii::t('app', 'CTPL') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'The remaining amount that the distributor must pay') ?> ">
                    <?= Yii::t('app', 'DTPL') ?>
                </a>
            </th>
            <!--            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<? /*= Yii::t('app', 'Total number of payments in plan') */ ?> ">
                    <? /*= Yii::t('app', 'NOP') */ ?>
                </a>
            </th>-->
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'The remaining number of payments from the customer') ?> ">
                    <?= Yii::t('app', 'CNPL') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'The remaining number of payments from the distributor') ?> ">
                    <?= Yii::t('app', 'DNPL') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Order country') ?> ">
                    <?= Yii::t('app', 'Country') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Title of system distributor') ?> ">
                    <?= Yii::t('app', 'Distributor') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Title of system end-user') ?> ">
                    <?= Yii::t('app', 'End-User') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>