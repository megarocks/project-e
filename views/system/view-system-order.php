<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */

$this->title = "System Order #" . $model->po_num . " details";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['list-orders']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update-order', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'po_num',
            'system_sn'
        ],
    ]) ?>

</div>
