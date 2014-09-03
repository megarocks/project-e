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
            <th><?= Yii::t('app', 'Registered At') ?></th>
            <th><?= Yii::t('app', 'Serial Number') ?></th>
            <th><?= Yii::t('app', 'PO#') ?></th>
            <th><?= Yii::t('app', 'Status') ?></th>
            <th><?= Yii::t('app', 'Country') ?></th>
            <th><?= Yii::t('app', 'Distributor') ?></th>
            <th><?= Yii::t('app', 'End-User') ?></th>
            <th><?= Yii::t('app', 'Actions') ?></th>
        </tr>
        </thead>
    </table>
</div>