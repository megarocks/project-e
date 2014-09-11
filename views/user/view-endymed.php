<?php

    use app\models\User;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /**@var $this yii\web\View */
    /**@var $model User */

    $this->title = Yii::t('app', 'User Details');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <p>
        <?php
            echo Html::a(Yii::t('app', 'View All'),
                ['index'],
                ['class' => 'btn btn-default']);
            echo "&nbsp";
            echo Html::a(Yii::t('app', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']);
            echo "&nbsp";
            echo Html::a(Yii::t('app', 'Delete'),
                ['#'],
                ['class'       => 'btn btn-danger delete-button',
                 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]);
        ?>
    </p>

    <?=
        DetailView::widget([
            'model'      => $model,
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