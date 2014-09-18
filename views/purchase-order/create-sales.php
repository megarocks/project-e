<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */

    $this->title = Yii::t('app', 'New Purchase Order');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-create">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>
</div>
