<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 11:55 AM
     */

    namespace app\assets;

    use yii\web\AssetBundle;

    class LoginAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [

        ];
        public $js = [
            'js/site/login-screen.js'
        ];
        public $depends = [
            'app\assets\AppAsset',
        ];
    }