<?php

    use yii\helpers\Html;
    use app\assets\ManufacturerAsset;

    ManufacturerAsset::register($this);

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('app', 'Manufacturers');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturers-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Register new manufacturer`s account'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
                   data-original-title="<?= Yii::t('app', 'Manufacturer First and Last Name') ?> ">
                    <?= Yii::t('app', 'Title') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Manufacturer contact email') ?> ">
                    <?= Yii::t('app', 'Email') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Manufacturer phone') ?> ">
                    <?= Yii::t('app', 'Phone') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>
