<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model app\models\EndUser */

    $this->title = Yii::t('app', 'Register new end-user accout');
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
