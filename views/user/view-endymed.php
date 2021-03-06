<?php

    use app\models\User;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /**@var $this yii\web\View */
    /**@var $model User */

    $this->title = Yii::t('app', 'User Details');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <p>
        <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
    </p>

    <?=
        PpdDetailView::widget([
            'model' => $model->toArray(),
            'attributes' => [
                'role',
                'first_name',
                'last_name',
                'email:email',
                'created_at',
                'updated_at'
            ]
        ])
    ?>
</div>