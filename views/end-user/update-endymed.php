<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $endUser app\models\EndUser */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Update End-User');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $endUser->title, 'url' => ['view', 'id' => $endUser->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="end-users-update">
    <?=
        $this->render('_form', [
            'endUser'     => $endUser,
            'relatedUser' => $relatedUser,
        ]) ?>

</div>
