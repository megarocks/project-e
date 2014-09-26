<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 12:05 PM
     */

    use app\assets\SystemsIndexEndUserAsset;
    use yii\helpers\Html;

    SystemsIndexEndUserAsset::register($this);

    $this->title = Yii::t('app', 'Systems');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">
    <table id="systems-table" class="table-hover">
        <thead>
        <tr>
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
                   data-original-title="<?= Yii::t('app', 'Code which can be used to passwordless access to system ') ?> ">
                    <?= Yii::t('app', 'Login Code') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'Date until which current unlock code is valid') ?> ">
                    <?= Yii::t('app', 'Next Locking Date') ?>
                </a>
            </th>
            <th>
                <a href="#" data-rel="tooltip"
                   data-original-title="<?= Yii::t('app', 'The remaining amount that the customer must pay') ?> ">
                    <?= Yii::t('app', 'CTPL') ?>
                </a>
            </th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>