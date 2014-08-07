<?php
/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 7/30/14
 * Time: 4:17 PM
 */

namespace app\assets;

use yii\web\AssetBundle;

class DistributorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        '/js/distributors-list.js'
    ];
    public $depends = [
        'app\assets\AppAsset',
        'app\assets\DataTableAsset',
    ];
}