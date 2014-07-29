<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DistributorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Distributors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Distributors',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'title',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
