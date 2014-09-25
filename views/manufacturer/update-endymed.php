<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $manufacturer app\models\Manufacturer */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Update manufacturer`s accout');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manufacturers'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-users-create">
    <?=
        $this->render('_form', [
            'manufacturer' => $manufacturer,
            'relatedUser'  => $relatedUser,
        ]) ?>

</div>
