<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 19.09.14
     * Time: 12:28
     */

    namespace app\widgets;


    use yii\widgets\DetailView;

    class PpdDetailView extends DetailView
    {
        public $template = "<tr><th width='50%'>{label}</th><td>{value}</td></tr>";

    }