<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SystemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Systems');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Systems',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'sn:text:Serial Number',
            'po:text:PO#',
            'email:email',
            'status',
            // 'cpup',
            // 'epup',
            // 'esp',
            // 'csp',
            // 'nop',
            // 'cmp',
            // 'emp',
            // 'dmp',
            // 'npl',
            // 'ctpl',
            // 'etpl',
            // 'dtpl',
            // 'current_code',
            'next_lock_date',
            // 'main_unlock_code',
            // 'end_user_id',
            // 'distributor_id',
            // 'country_id',
            // 'currency_id',
            // 'created_at',
            // 'updated_at',
            'distributortitle',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
