<?php

use yii\helpers\Html;
use app\assets\PoIndexProductionAsset;

PoIndexProductionAsset::register($this);

$this->title = Yii::t('app', 'System Orders');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="systems-orders-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table id="systems-po-table" class="table-hover">
        <thead>
        <tr>
            <th>Added at</th>
            <th>Purchase Order #</th>
            <th>System SN</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>