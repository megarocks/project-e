<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\EndUsers */

    $this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'End Users',
        ]) . ' ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="end-users-update">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>
