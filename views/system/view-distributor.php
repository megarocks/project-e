<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Systems */

$this->title = "System #" . $model->sn . " management";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $po = $model->purchaseOrder; ?>

<div class="systems-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Generate Code'), ['generate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sn',
            [
                'label' => Yii::t('app', 'PO# (Purchase Order #)'),
                'value' => $po->po_num
            ],
            [
                'label' => Yii::t('app', 'NPL (Number of payments left)'),
                'value' => $po->npl,
            ],
            [
                'label' => Yii::t('app', 'CTPL (Customer Total Payment Left)'),
                'value' => $po->ctpl,
            ],
        ],
    ]) ?>

</div>
