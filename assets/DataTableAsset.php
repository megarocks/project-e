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
        '//cdn.datatables.net/1.10.1/css/jquery.dataTables.css',
    ];
    public $js = [
        '//cdn.datatables.net/1.10.1/js/jquery.dataTables.js',
        '/js/systems-list.js'
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}