<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataTableAsset;
use app\assets\EndUsersAsset;

DataTableAsset::register($this);
EndUsersAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EndUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'End Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'End Users',
        ]), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="end-users-table" class="table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>