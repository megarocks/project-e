<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\assets\DistributorAsset;

DistributorAsset::register($this);

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Distributors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Register new distributor'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="distributors-table" class="table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Email</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
