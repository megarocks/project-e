<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Systems');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'System',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'sn',
            //'po',
            //'status',
            //'cpup',
            // 'epup',
            // 'esp',
            // 'csp',
            // 'nop',
            // 'cmp',
            // 'emp',
            // 'dmp',
            'npl',
            'ctpl',
            // 'etpl',
            // 'dtpl',
            'current_code',
            'next_lock_date',
            // 'main_unlock_code',
            // 'end_user_id',
            // 'distributer_id',
            // 'country_id',
            'currency_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
