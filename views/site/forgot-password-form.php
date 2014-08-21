<?php
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Collapse;
    use yii\helpers\Html;
    use app\widgets\LoginForm;

    $this->title = Yii::t('app', 'Forgot Password');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'id' => 'forgot-password-form',
    ])?>
    <?= $form->field($model, 'email')->textInput() ?>
    <div class="text-center">
        <?= Html::submitButton('Remind', ['class' => 'btn btn-primary', 'name' => 'remind-button']) ?>
    </div>
</div>
