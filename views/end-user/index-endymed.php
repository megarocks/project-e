<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use app\assets\DataTableAsset;
    use app\assets\EndUsersAsset;

    DataTableAsset::register($this);
    EndUsersAsset::register($this);

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('app', 'End Users');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-users-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Create end-user'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="end-users-table" class="table-hover">
        <thead>
        <tr>
            <th>Registered At</th>
            <th>Title</th>
            <th>Email</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
