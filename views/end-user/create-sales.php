<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $endUser app\models\EndUser */
    /* @var $relatedUser app\models\User */
    /* @var $countriesList array */

    $this->title = Yii::t('app', 'Register new end-user accout');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-users-create">
    <?=
        $this->render('_form', [
            'endUser'     => $endUser,
            'relatedUser' => $relatedUser,
            'countriesList' => $countriesList,
        ]) ?>

</div>