<?php

use app\assets\PurchaseOrderAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */

PurchaseOrderAsset::register($this);

$this->title = Yii::t('app', 'Purchase Order Details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="po-view">
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
            'po_num',
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
            'country_id',
            'distributor_id',
            'email:email',
            'created_at',
            'updated_at'
        ],
    ]) ?>

</div>