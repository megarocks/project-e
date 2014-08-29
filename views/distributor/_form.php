<?php

    use app\models\Country;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model app\models\Distributor */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="distributors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($model, 'country_id')->dropDownList(
            ['' => Yii::t('app', 'Select Country...')] +
            ArrayHelper::map(Country::find()->all(), 'id_countries', 'name')
        )
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 45]) ?>

    <?= $form->errorSummary($model) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
