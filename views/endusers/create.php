<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EndUsers */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'End Users',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
