<?php

use yii\helpers\VarDumper;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();

/**
 * Dump variables.
 *
 * @param mixed $var Variable, that must be dumped.
 * @param bool $needToExit
 * @return bool|mixed
 */
function D($var, $needToExit = false)
{
    if (function_exists('debug_backtrace')) {
        $Tmp1 = debug_backtrace();
    } else {
        $Tmp1 = array(
            'file' => 'UNKNOWN FILE',
            'line' => 'UNKNOWN LINE',
        );
    }

    if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {
        var_dump($var);
    } else {
        echo "<FIELDSET STYLE=\"font:normal 12px helvetica,arial; margin:10px;\"><LEGEND STYLE=\"font:bold 14px helvetica,arial\">Dump - " . $Tmp1[0]['file'] . " : " . $Tmp1[0]['line'] . "</LEGEND><PRE style='padding: 0px; margin:0px;'>\n";
        VarDumper::dump($var, 20, 1);
        echo "</PRE></FIELDSET>";
    }

    if ($needToExit) {
        Yii::$app->end();
    }

    return true;
}
