<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $salesUser app\models\SalesUser */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Register new sales-user accout');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-users-create">
    <?=
        $this->render('_form', [
            'salesUser'   => $salesUser,
            'relatedUser' => $relatedUser,
        ]) ?>

</div>
