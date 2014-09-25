<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $distributor app\models\Distributor */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Registering new distributor');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-create">
    <?=
        $this->render('_form', [
            'distributor' => $distributor,
            'relatedUser' => $relatedUser,
        ]) ?>

</div>
