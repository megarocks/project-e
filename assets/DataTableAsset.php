<?php
/**
 * Created by PhpStorm.
 * User: rocks
 * Date: 7/30/14
 * Time: 11:55 AM
 */

namespace app\assets;

use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendors/datatables/css/jquery.dataTables.min.css',
    ];
    public $js = [
        'vendors/datatables/js/jquery.dataTables.min.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}