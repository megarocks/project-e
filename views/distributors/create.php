<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distributors */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Distributors',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
