<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 8/6/14
     * Time: 5:17 PM
     */
    use app\assets\PoIndexManufacturerAsset;
    use yii\helpers\Html;

    PoIndexManufacturerAsset::register($this);

    $this->title = Yii::t('app', 'Purchase Orders');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-orders-index">
    <p>

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
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>