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
        <?php if (is_null($model->system_sn)) :
            echo Html::a(Yii::t('app', 'Assign System'), ['system/assign', 'po_id' => $model->id], ['class' => 'btn btn-primary']);
        endif;
        ?>
    </p>

    <?=
        PpdDetailView::widget([
            'model'      => $model,
            'attributes' => [
                'po_num',
                'system_sn',
                'createdAt',
            ],
        ]) ?>

</div>