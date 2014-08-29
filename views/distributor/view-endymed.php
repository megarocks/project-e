<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\Distributor */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
        DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'title',
                'email:email',
                'countryName',
            ],
        ]) ?>

</div>
