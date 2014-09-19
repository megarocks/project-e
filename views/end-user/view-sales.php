<?php

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\EndUser */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-users-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
        PpdDetailView::widget([
            'model'      => $model,
            'attributes' => [
                'title',
                'email:email',
                [
                    'label' => Yii::t('app', 'Country'),
                    'value' => $model->country->name,
                ],
            ],
        ]) ?>

</div>
