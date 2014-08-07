<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distributor */

$this->title = Yii::t('app', 'Registering new distributor');
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
