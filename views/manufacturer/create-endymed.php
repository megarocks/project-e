<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $salesUser app\models\Manufacturer */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Register new manufacturer`s accout');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manufacturers'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-user-create">
    <?=
        $this->render('_form', [
            'manufacturer' => $manufacturer,
            'relatedUser'  => $relatedUser,
        ]) ?>

</div>
