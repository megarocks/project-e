<?php

    use yii\helpers\Html;
    use app\assets\EndUsersAsset;

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
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this account was added to database') ?> ">
                    <?= Yii::t('app', 'Registered At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'End-User title') ?> ">
                    <?= Yii::t('app', 'Title') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'End-User contact email') ?> ">
                    <?= Yii::t('app', 'Email') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'End-User country') ?> ">
                    <?= Yii::t('app', 'Country') ?>
                </a>
            </th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
