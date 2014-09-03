<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/3/14
     * Time: 5:14 PM
     */

    namespace app\helpers;


    use Yii;

    class FlashAlert
    {

        public static function flashArea($delete = false)
        {
            $alerts = Yii::$app->session->getAllFlashes($delete);
            $alertDivs = '';

            foreach ($alerts as $key => $message) {
                $alertContent = '<div class="alert alert-' . $key . '">' .
                    '<button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>' .
                    $message .
                    '</div>';
                $alertDivs .= $alertContent;
            }

            return $alertDivs;
        }

    }