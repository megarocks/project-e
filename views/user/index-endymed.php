<?php

    use app\assets\UsersIndexEndymedAsset;
    use yii\helpers\Html;

    UsersIndexEndymedAsset::register($this);

    $this->title = Yii::t('app', 'Users');
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Register new account'),
                ['create'],
                ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="users-table" class="table-hover">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Registered At') ?></th>
            <th><?= Yii::t('app', 'First Name') ?></th>
            <th><?= Yii::t('app', 'Last Name') ?></th>
            <th><?= Yii::t('app', 'Email') ?></th>
            <th><?= Yii::t('app', 'Role') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>