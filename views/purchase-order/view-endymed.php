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

<div class="po-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (is_null($model->system)) :
            echo Html::a(Yii::t('app', 'Assign to System'), ['system/assign', 'po_id' => $model->id], ['class' => 'btn btn-primary']);
            if ($model->editable) :
                echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                echo Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]);
            endif;
        endif; ?>
        <?php if (!is_null($model->system) && $model->editable) :
            echo Html::a(Yii::t('app', 'Unassign from System'), ['system/unassign', 'id' => $model->system->id], ['class' => 'btn btn-danger']);
        endif; ?>
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