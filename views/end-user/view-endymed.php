<?php

    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\EndUser */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'End-users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
    </p>

    <?=
        PpdDetailView::widget([
            'model'      => $model,
            'attributes' => [
                [
                    'label' => Yii::t('app', 'Country'),
                    'value' => $model->country->name,
                ],
                'title',
                'email:email',
                'phone',
                'contact_person',
                [
                    'label' => Yii::t('app', 'Assigned to distributor'),
                    'value' => $model->distributor->title,
                ]
            ],
        ]) ?>

</div>
