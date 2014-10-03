<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 7/30/14
     * Time: 11:55 AM
     */

    namespace app\assets;

    use yii\web\AssetBundle;

    class SystemsIndexManufacturerAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [

        ];
        public $js = [
            'js/system/systems-index-manufacturer.js'
        ];
        public $depends = [
            'app\assets\AppAsset',
            'app\assets\DataTableAsset',
        ];
    }