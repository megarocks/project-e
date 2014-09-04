<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 12:05 PM
     */

    use app\assets\SystemsIndexDistributorAsset;
    use yii\helpers\Html;

    SystemsIndexDistributorAsset::register($this);

    $this->title = Yii::t('app', 'Systems');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="systems-index">
    <table id="systems-table" class="table-hover">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Serial Number') ?></th>
            <th><?= Yii::t('app', 'PO#') ?></th>
            <th><?= Yii::t('app', 'Status') ?></th>
            <th><?= Yii::t('app', 'Login Code') ?></th>
            <th><?= Yii::t('app', 'Initial Locking Date') ?></th>
            <th><?= Yii::t('app', 'Next Locking Date') ?></th>
            <th><?= Yii::t('app', 'DTPL') ?></th>
            <th><?= Yii::t('app', 'CTPL') ?></th>
            <th><?= Yii::t('app', 'End-User') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>