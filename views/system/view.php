<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\System */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sn',
            'po',
            'status',
            'cpup',
            'epup',
            'esp',
            'csp',
            'nop',
            'cmp',
            'emp',
            'dmp',
            'npl',
            'ctpl',
            'etpl',
            'dtpl',
            'current_code',
            'next_lock_date',
            'main_unlock_code',
            'end_user_id',
            'distributer_id',
            'country_id',
            'currency_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
