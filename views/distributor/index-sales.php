<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    use app\assets\DistributorAsset;

    DistributorAsset::register($this);

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('app', 'Distributors');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributors-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Register new distributor'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <table id="distributors-table" class="table-hover">
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
                   data-original-title="<?= Yii::t('app', 'Distributor title') ?> ">
                    <?= Yii::t('app', 'Title') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Distributor contact email') ?> ">
                    <?= Yii::t('app', 'Email') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Distributor country') ?> ">
                    <?= Yii::t('app', 'Country') ?>
                </a>
            </th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
