<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 12:05 PM
     */

    use app\assets\SystemsIndexEndymedAsset;
    use yii\helpers\Html;

    SystemsIndexEndymedAsset::register($this);

    $this->title = Yii::t('app', 'Systems');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">
    <p>
        <?=
            Html::a(Yii::t('app', 'Register new system'), ['create'], ['class' => 'btn btn-success btn-sm'])
        ?>
    </p>

    <table id="systems-table" class="table-hover">
        <thead>
        <tr>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date and time when this system was added to database') ?> ">
                    <?= Yii::t('app', 'Registered At') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'System serial number') ?> ">
                    <?= Yii::t('app', 'System SN') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Order number to which system is assigned') ?> ">
                    <?= Yii::t('app', 'PO#') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip" data-original-title="<?= Yii::t('app', 'Current system status') ?> ">
                    <?= Yii::t('app', 'Status') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'System country') ?> ">
                    <?= Yii::t('app', 'Country') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Title of system distributor') ?> ">
                    <?= Yii::t('app', 'Distributor') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Title of system end-user') ?> ">
                    <?= Yii::t('app', 'End-User') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>