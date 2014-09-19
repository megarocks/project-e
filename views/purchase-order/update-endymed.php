<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */

    $this->title = Yii::t('app', 'Update Purchase Order');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Order #{po_num}', ['po_num' => $model->po_num]), 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

