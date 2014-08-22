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
            'css/ace.min.css',
            'css/ace-extra.min.css',
            'css/ace-fonts.min.css',
        ];
        public $js = [
        ];
        public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'app\assets\AppAsset',
        ];
    }
