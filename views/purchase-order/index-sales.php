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
            <th><?= Yii::t('app', 'Added at') ?></th>
            <th><?= Yii::t('app', 'PO#') ?></th>
            <th><?= Yii::t('app', 'System SN') ?></th>
            <th><?= Yii::t('app', 'CTPL') ?></th>
            <th><?= Yii::t('app', 'DTPL') ?></th>
            <th><?= Yii::t('app', 'NOP') ?></th>
            <th><?= Yii::t('app', 'CNPL') ?></th>
            <th><?= Yii::t('app', 'DNPL') ?></th>
            <th><?= Yii::t('app', 'Country') ?></th>
            <th><?= Yii::t('app', 'Distributor') ?></th>
            <th><?= Yii::t('app', 'End-User') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>