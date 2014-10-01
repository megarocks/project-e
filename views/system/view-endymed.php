<?php

    use app\models\PurchaseOrder;
    use app\widgets\PpdDetailView;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $po app\models\PurchaseOrder */
    $po = $model->purchaseOrder;

    $this->title = "System #" . $model->sn . " management";
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    Yii::$app->user->setReturnUrl(Url::to());
?>

<?php if (!is_null($po)) : ?>
    <div class="systems-view">
        <p>
            <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
            <?php if ($po->editable) : ?>
                <?= Html::a(Yii::t('app', 'Unassign from PO'), ['unassign', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
            <?php endif; ?>
            <?php if (($po->ctpl > 0) || ($po->dtpl > 0)) : ?>
                <?= Html::a(Yii::t('app', 'Add Payment'), ['/payment/create', 'access_token' => $model->access_token], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </p>

        <h3><?= Yii::t('app', 'System Details') ?> </h3>

        <?php
            $systemDetailsAttributes = [];
            if ($po->cnpl > 0) :
                $systemDetailsAttributes = ['sn', 'systemStatus', 'login_code', 'main_unlock_code', 'current_code', 'initialLockingDate', 'nextLockingDate', 'createdAt'];
            else :
                $systemDetailsAttributes = ['sn', 'systemStatus', 'login_code', 'main_unlock_code', 'createdAt'];
            endif; ?>

        <div class="well">
            <?=
                PpdDetailView::widget([
                    'model'      => $model,
                    'attributes' => $systemDetailsAttributes,
                ]) ?>
        </div>

        <h3><?= Yii::t('app', 'Customer monetary details') ?> </h3>
        <?=
            PpdDetailView::widget([
                'model'      => $po,
                'attributes' => ['po_num', 'csp', 'cpup', 'nop', 'cnpl', 'ctpl', 'cmp',]
            ]) ?>

        <h3><?= Yii::t('app', 'Distributor monetary details') ?> </h3>
        <?=
            PpdDetailView::widget([
                'model'      => $po,
                'attributes' => ['po_num', 'dsp', 'dpup', 'nop', 'dnpl', 'dtpl', 'dmp']
            ]) ?>

    </div>
<?php endif; ?>

<?php if (is_null($po)) : ?>

    <div class="systems-view">

        <p>
            <?= Html::a(Yii::t('app', 'View All'), ['index'], ['class' => 'btn btn-default']); ?>
            <?= Html::a(Yii::t('app', 'Assign to PO'), ['assign', 'system_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['#'], ['class' => 'btn btn-danger delete-button', 'requestLink' => Url::toRoute(['delete', 'id' => $model->id])]); ?>
        </p>

        <?php
            $systemDetailsAttributes = ['sn', 'systemStatus', 'login_code', 'main_unlock_code', 'current_code', 'initialLockingDate', 'nextLockingDate', 'createdAt'];
        ?>

        <div class="well">
            <?=
                PpdDetailView::widget([
                    'model'      => $model,
                    'attributes' => $systemDetailsAttributes,
                ]) ?>
        </div>

    </div>

<?php endif; ?>

