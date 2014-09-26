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
        <?php if (isset($po)) :
            echo '<p>' . Yii::t("app", "Contact EndyMed support to request capability to edit this system details: {support_email}",
                    ['support_email' => '<a href=mailto:' . Yii::$app->params["mainSupportEmail"] . '>' . Yii::$app->params["mainSupportEmail"] . '</a>']) . '</p>';
            ?>
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
                    'systemStatus',
                    'createdAt',
                ],
            ]) ?>
    </div>

</div>
