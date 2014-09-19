<?php

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */


    $this->title = Yii::t('app', 'Purchase Order Details');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    Yii::$app->user->setReturnUrl(Url::to());
?>

<div class="po-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (is_null($model->system)) : ?>
            <?= Html::a(Yii::t('app', 'Assign to System'), ['system/assign', 'po_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
        <?php endif; ?>
        <?php if (!is_null($model->system)) : ?>
            <?= Html::a(Yii::t('app', 'Unassign from System'), ['system/unassign', 'id' => $model->system->id], ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </p>

    <?=
        PpdDetailView::widget([
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
                [
                    'label' => Yii::t('app', 'Created at'),
                    'value' => $model->toArray(['created_at'])['created_at'],
                ],
                [
                    'label' => Yii::t('app', 'Updated at'),
                    'value' => $model->toArray(['updated_at'])['updated_at'],
                ],
            ],
        ]) ?>

</div>