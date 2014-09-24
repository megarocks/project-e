<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $distributor app\models\Distributor */
    /* @var $relatedUser app\models\User */

    $this->title = Yii::t('app', 'Update Distributor');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $distributor->title, 'url' => ['view', 'id' => $distributor->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="distributors-update">
    <?=
        $this->render('_form', [
            'distributor' => $distributor,
            'relatedUser' => $relatedUser,
        ]) ?>

</div>
