<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/9/14
     * Time: 11:24 AM
     */

    namespace app\models;


    use yii\db\ActiveRecord;
    use Yii;

    abstract class PpdBaseModel extends ActiveRecord
    {

        abstract public function createModel();

        abstract public function updateModel();

        /**
         * Returns array of models which are visible for current user
         *
         * @param $conditions array|null
         * @return array
         */
        public static function findAllFiltered($conditions = null)
        {
            $reflectionClass = new \ReflectionClass(static::className());
            $modelClassShortName = $reflectionClass->getShortName();
            $filteredModels = [];
            foreach ((is_array($conditions)) ? static::find()->where($conditions)->all() : static::find()->all() as $model) {
                if (Yii::$app->user->can('view' . $modelClassShortName, ['modelId' => $model->id])) {
                    $filteredModels[] = $model;
                }
            }

            return $filteredModels;
        }
    }