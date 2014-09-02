<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */


    $this->title = Yii::t('app', 'Purchase Order Details');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="po-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!--<?/*=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method'  => 'post',
                ],
            ]) */?> -->
    </p>

    <?=
        DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'po_num',
                'cpup',
                'dpup',
                'dsp',
                'csp',
                'nop',
                'dnpl',
                'cnpl',
                'cmp',
                'dmp',
                'ctpl',
                'dtpl',
                [
                    'label' => Yii::t('app', 'Country'),
                    'value' => isset($model->country) ? $model->country->name : Yii::t('app', 'Country is not defined'),
                ],
                [
                    'label' => Yii::t('app', 'Distributor'),
                    'value' => isset($model->distributor) ? $model->distributor->title : Yii::t('app', 'Distributor not assigned'),
                ],
                [
                    'label' => Yii::t('app', 'End-User'),
                    'value' => isset($model->endUser) ? $model->endUser->title : Yii::t('app', 'End-User not assigned'),
                ],
                'email:email',
                'created_at',
                'updated_at'
            ],
        ]) ?>

</div>