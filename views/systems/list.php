<?php
/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 7/30/14
 * Time: 12:05 PM
 */

use app\assets\DataTableAsset;
use app\assets\SystemsAsset;
use yii\helpers\Html;

DataTableAsset::register($this);
SystemsAsset::register($this);

$this->title = Yii::t('app', 'Systems');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Add New System', [
            'modelClass' => 'Systems',
        ]), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="example-table">
        <thead>
        <tr>
            <th>Serial Number</th>
            <th>PO</th>
            <th>Attached Email</th>
            <th>Status</th>
            <th>Next Locking Date</th>
            <th>Distributor</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>