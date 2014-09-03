<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\User */

    $this->title = Yii::t('app', 'Update user account');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>