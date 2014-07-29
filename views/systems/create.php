<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\System */

$this->title = Yii::t('app', 'Add new {modelClass}', [
    'modelClass' => 'System',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
