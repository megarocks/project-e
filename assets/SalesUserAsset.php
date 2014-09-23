<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 4:52 PM
     */
    namespace app\assets;

    use yii\web\AssetBundle;

    class SalesUserAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [];
        public $js = [
            '/js/sales-user/sales-user-index.js'
        ];
        public $depends = [
            'app\assets\AppAsset',
            'app\assets\DataTableAsset',
        ];
    }