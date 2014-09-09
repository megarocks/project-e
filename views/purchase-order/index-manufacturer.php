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
            <th><?= Yii::t('app', 'Added at') ?></th>
            <th><?= Yii::t('app', 'PO#') ?></th>
            <th><?= Yii::t('app', 'System SN') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>