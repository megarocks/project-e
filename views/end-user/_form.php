<?php

    use app\models\Country;
    use app\models\Distributor;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model app\models\EndUser */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="end-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($model, 'country_id')->dropDownList(
            ['' => Yii::t('app', 'Select Country...')] +
            ArrayHelper::map(Country::find()->all(), 'id', 'name')
        )
    ?>

    <?=
        $form->field($model, 'distributor_id')->dropDownList(
            ['' => Yii::t('app', 'Select Distributor...')] +
            ArrayHelper::map(Distributor::findAllFiltered(), 'id', 'title')
        )
    ?>

    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'contact_person')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
