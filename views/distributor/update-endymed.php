<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\Distributor */

    $this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Distributors',
        ]) . ' ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="distributors-update">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>
