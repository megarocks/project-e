<?php

    use app\assets\UsersIndexEndymedAsset;
    use yii\helpers\Html;

    UsersIndexEndymedAsset::register($this);

    $this->title = Yii::t('app', 'Admins');
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Register new admin'),
                ['create'],
                ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="users-table" class="table-hover">
        <thead>
        <tr>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this account was added to database') ?> ">
                    <?= Yii::t('app', 'Registered At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'User first name') ?> ">
                    <?= Yii::t('app', 'First Name') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'User last name') ?> ">
                    <?= Yii::t('app', 'Last Name') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Email is also used as username for login') ?> ">
                    <?= Yii::t('app', 'Email') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Determines set of permissions') ?> ">
                    <?= Yii::t('app', 'Role') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>