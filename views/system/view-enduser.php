<?php

use app\models\PurchaseOrder;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
    /* @var $model app\models\System */
    /**@var PurchaseOrder $po */

$this->title = "System #" . $model->sn . " management";
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . '</div>';
    }
?>

<div class="systems-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Request Code'), ['payment/request-code', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

    <div class="well">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'sn',
                'status',
                'login_code',
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
