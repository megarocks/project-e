<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\User */

    $this->title = Yii::t('app', 'Register new user');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>