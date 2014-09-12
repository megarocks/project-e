<?php
    /**
     * @link http://www.yiiframework.com/
     * @copyright Copyright (c) 2008 Yii Software LLC
     * @license http://www.yiiframework.com/license/
     */

    namespace app\themes\ace\assets;

    use yii\web\AssetBundle;

    /**
     * @author Qiang Xue <qiang.xue@gmail.com>
     * @since 2.0
     */
    class AceAsset extends AssetBundle
    {
        public $sourcePath = '@app/themes/ace/assets/general/source';

        public $publishOptions
            = [
                'forceCopy' => YII_DEBUG,
            ];

        public $css = [
            'css/uncompressed/ace.css',
            'css/ace-fonts.css',
            'css/font-awesome.min.css',
            'css/ace-skins.min.css',
        ];
        public $js = [
            'js/ace/ace.js',
            'js/ace-elements.min.js',
            'js/ace-extra.min.js',
            'js/bootbox.min.js',
        ];
        public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'app\assets\AppAsset',
        ];
    }
