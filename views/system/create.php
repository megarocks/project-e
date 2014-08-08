<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Systems */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Systems',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
