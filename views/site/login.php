<?php
    use yii\bootstrap\Collapse;
    use yii\helpers\Html;
    use app\widgets\LoginForm;

    /* @var $this yii\web\View */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $credentialsLoginForm app\models\CredentialsLoginForm */
    /* @var $codeLoginForm app\models\CodeLoginForm */
    /* @var $initForm boolean */

    $this->title = 'Login';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
        Collapse::widget([
            'items' => [
                Yii::t('app', 'Login by code')        => [
                    'content'        => LoginForm::widget(['model' => $codeLoginForm, 'formType' => 'code']),
                    'contentOptions' => $initForm == 'code' ? ['class' => 'in'] : [],
                ],
                Yii::t('app', 'Login by credentials') => [
                    'content'        => LoginForm::widget(['model' => $credentialsLoginForm, 'formType' => 'credentials']),
                    'contentOptions' => $initForm == 'credentials' ? ['class' => 'in'] : [],
                ]
            ]
        ]); ?>

</div>
