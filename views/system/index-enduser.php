<?php
/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 7/30/14
 * Time: 12:05 PM
 */

use app\assets\SystemsIndexEndUserAsset;
use yii\helpers\Html;

SystemsIndexEndUserAsset::register($this);

$this->title = Yii::t('app', 'Systems');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table id="systems-table" class="table-hover">
        <thead>
        <tr>
            <th>Serial Number</th>
            <th>PO</th>
            <th>Status</th>
            <th>Next Locking Date</th>
            <th>Current Code</th>
            <th>Payment Left</th>
            <th>Number of left payments</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>