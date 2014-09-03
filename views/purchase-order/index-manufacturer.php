<?php

    use yii\helpers\Html;
    use app\assets\PoIndexProductionAsset;

    PoIndexProductionAsset::register($this);

    $this->title = Yii::t('app', 'System Orders');
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="systems-orders-index">
    <table id="systems-po-table" class="table-hover">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Added at') ?></th>
            <th><?= Yii::t('app', 'Purchase Order #') ?></th>
            <th><?= Yii::t('app', 'System SN') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>