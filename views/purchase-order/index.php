<?php
/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 8/6/14
 * Time: 5:17 PM
 */
use app\assets\DataTableAsset;
use app\assets\SystemsAsset;
use yii\helpers\Html;

DataTableAsset::register($this);
SystemsAsset::register($this);

$this->title = Yii::t('app', 'Purchase Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-orders-index">
    <h1><?= Html::encode($this->title) ?></h1>

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
            <th>Added at</th>
            <th>PO#</th>
            <th>CPUP</th>
            <th>EPUP</th>
            <th>ESP</th>
            <th>CSP</th>
            <th>NOP</th>
            <th>Distributer</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>