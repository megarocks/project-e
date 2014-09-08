<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/8/14
     * Time: 12:55 PM
     */

    namespace app\models;


    interface PpdModelInterface
    {
        /**
         * @return boolean
         */
        public function createModel();

        /**
         * @return boolean
         */
        public function updateModel();

    }