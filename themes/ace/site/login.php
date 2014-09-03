<?php

    use app\themes\ace\assets\AceAsset;
    use app\assets\LoginAsset;
    use app\themes\ace\widgets\LoginForm;
    use yii\helpers\Html;

    AceAsset::register($this);
    LoginAsset::register($this);

    /* @var $this yii\web\View */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $credentialsLoginForm app\models\CredentialsLoginForm */
    /* @var $codeLoginForm app\models\CodeLoginForm */
    /* @var $forgotPasswordForm app\models\ForgotPasswordForm */
    /* @var $initForm boolean */
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="login-layout">
    <?php $this->beginBody() ?>

    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                                <i class="glyphicon glyphicon-certificate orange2"></i>
                                <span class="orange2">PPD Control Panel</span>
                            </h1>
                            <h4 class="blue">
                                &copy; EndyMed <?= date('Y') ?>
                            </h4>
                        </div>
                        <div class="space-6"></div>
                        <div class="position-relative">
                            <div id="login-box" class="login-box widget-box no-border visible">
                                <div class="widget-body">
                                    <!--widget main-->
                                    <?= LoginForm::widget(['model' => $credentialsLoginForm, 'formType' => 'credentials']) ?>
                                    <div class="toolbar clearfix">
                                        <div class="forgot-password center">
                                            <?=
                                                Html::a(Yii::t('app', 'I forgot my password'), '#',
                                                    [
                                                        'class'       => 'forgot-password-link',
                                                        'data-target' => '#forgot-box'
                                                    ]) ?>
                                        </div>
                                    </div>
                                    <!--end toolbar-->
                                </div>
                                <!--end widget body-->
                            </div>
                            <!--end login box-->
                            <div id="forgot-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <?= LoginForm::widget(['model' => $forgotPasswordForm, 'formType' => 'forgot-password']) ?>
                                </div>
                                <!--end forgot box widget body-->
                            </div>
                            <!--end forgot-box-->
                        </div>
                        <!--end position relative-->
                    </div>
                    <!--end login container-->
                </div>
                <!--end col-sm-10-->
            </div>
            <!--end row-->
        </div>
        <!--end main content-->
    </div>
    <!--end main container-->

    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>