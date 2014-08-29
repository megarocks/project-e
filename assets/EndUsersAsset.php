<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 4:52 PM
     */
    namespace app\assets;

    use yii\web\AssetBundle;

    class EndUsersAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [];
        public $js = [
            '/js/end-user/endusers-index-endymed.js'
        ];
        public $depends = [
            'app\assets\AppAsset',
        ];
    }