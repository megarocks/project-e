<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model app\models\User */

    $this->title = Yii::t('app', 'Register new admin');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admins'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    //user create form is used only for admins creation
    $model->roleField = \app\models\User::ROLE_ENDY;
?>
<div class="user-create">
    <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>