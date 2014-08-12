<?php

use app\models\PurchaseOrder;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Systems */
/**@var PurchaseOrder $po */

$this->title = "System #" . $model->sn . " management";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="systems-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Request Code'), ['request-code', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

    <div class="well">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'sn',
                'status',
                'current_code',
                'next_lock_date',
                [
                    'label' => Yii::t('app', 'Email'),
                    'value' => $po->email,
                ],
            ],
        ]) ?>
    </div>

    <h3><?= Yii::t('app', 'Monetary details') ?> </h3>
    <?=
    DetailView::widget([
        'model' => $po,
        'attributes' => [
            'po_num',
            'csp',
            'cpup',
            'nop',
            'ctpl',
            'cmp',
            'npl'
        ],
    ]) ?>
</div>
