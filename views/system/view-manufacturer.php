<?php

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $po app\models\PurchaseOrder */
    $po = $model->purchaseOrder;

    $this->title = "System #" . $model->sn . " management";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    Yii::$app->user->setReturnUrl(Url::to());
?>

<div class="systems-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (!isset($po) && Yii::$app->user->can('assignSystem')) : ?>
            <?= Html::a(Yii::t('app', 'Assign to PO'), ['assign', 'system_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (isset($po) && Yii::$app->user->can('unAssignSystem')) : ?>
            <?= Html::a(Yii::t('app', 'Unassign from PO'), ['unassign', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </p>

    <h3><?= Yii::t('app', 'System Details') ?> </h3>

    <div class="well">
        <?=
            PpdDetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'sn',
                    [
                        'label' => Yii::t('app', 'Purchase Order #'),
                        'value' => isset($model->purchaseOrder) ? $model->purchaseOrder->po_num : Yii::t('app', 'Not Assigned'),
                    ],
                    [
                        'label' => Yii::t('app', 'Status'),
                        'value' => $model->toArray(['status'])['status'],
                    ],
                    'created_at'
                ],
            ]) ?>
    </div>

</div>
