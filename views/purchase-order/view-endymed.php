<?php

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */


    $this->title = Yii::t('app', 'Purchase Order #{po_num} Details', ['po_num' => $model->po_num]);
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    Yii::$app->user->setReturnUrl(Url::to());
?>

<?php if (is_null($model->system)) : ?>

    <div class="po-view">
        <p>
            <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
            <?= Html::a(Yii::t('app', 'Assign to System'), ['system/assign', 'po_id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?php if ($model->editable) : ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
            <?php endif; ?>
        </p>

        <?=
            PpdDetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'po_num',
                    [
                        'label' => Yii::t('app', 'Country'),
                        'value' => isset($model->country) ? $model->country->name : Yii::t('app', 'Country is not defined'),
                    ],
                    'csp',
                    'dsp',
                    'cpup',
                    'dpup',
                    'nop',
                    'cnpl',
                    'cmp',
                    'ctpl',
                    'dnpl',
                    'dmp',
                    'dtpl',
                    [
                        'label' => Yii::t('app', 'Distributor'),
                        'value' => isset($model->distributor) ? $model->distributor->title : Yii::t('app', 'Distributor not assigned'),
                    ],
                    [
                        'label' => Yii::t('app', 'End-User'),
                        'value' => isset($model->endUser) ? $model->endUser->title : Yii::t('app', 'End-User not assigned'),
                    ],
                    'createdAt',
                    'updatedAt'
                ],
            ]) ?>

    </div>

<?php endif; ?>

<?php if (!is_null($model->system)) : ?>
<div class="po-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (count($model->payments) > 0) : ?>
            <?= Html::a(Yii::t('app', 'View Payments'), ['/purchase-order/payments', 'id' => $model->id], ['class' => 'btn btn-default']); ?>
        <?php endif; ?>
        <?php if ((($model->dtpl > 0) || ($model->ctpl > 0))) : ?>
            <?= Html::a(Yii::t('app', 'Add Payment'), ['payment/create', 'access_token' => $model->system->access_token], ['class' => 'btn btn-primary']); ?>
        <?php endif; ?>
        <?php if ($model->editable) : ?>
            <?= Html::a(Yii::t('app', 'Unassign from System'), ['system/unassign', 'id' => $model->system->id], ['class' => 'btn btn-danger']); ?>
        <?php endif; ?>
    </p>

    <?=
        PpdDetailView::widget([
            'model'      => $model,
            'attributes' => [
                'po_num',
                [
                    'label' => Yii::t('app', 'Country'),
                    'value' => isset($model->country) ? $model->country->name : Yii::t('app', 'Country is not defined'),
                ],
                'csp',
                'dsp',
                'cpup',
                'dpup',
                'nop',
                'cnpl',
                'cmp',
                'ctpl',
                'dnpl',
                'dmp',
                'dtpl',
                [
                    'label' => Yii::t('app', 'Distributor'),
                    'value' => isset($model->distributor) ? $model->distributor->title : Yii::t('app', 'Distributor not assigned'),
                ],
                [
                    'label' => Yii::t('app', 'End-User'),
                    'value' => isset($model->endUser) ? $model->endUser->title : Yii::t('app', 'End-User not assigned'),
                ],
                'lastPaymentDate',
                'createdAt',
                'updatedAt'
                ],
        ]) ?>

    <?php endif; ?>
