<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/9/14
     * Time: 11:24 AM
     */

    namespace app\models;


    use yii\base\Exception;
    use yii\db\ActiveRecord;
    use Yii;

    /**
     * Class PpdBaseModel
     * @package app\models
     *
     * @property string $createdAt
     * @property string $updatedAt
     */
    abstract class PpdBaseModel extends ActiveRecord
    {

        abstract public function createModel();

        abstract public function updateModel();

        abstract public function deleteModel();

        /**
         * Returns array of models which are visible for current user
         *
         * @param $conditions array|null
         * @throws Exception
         * @throws \Exception
         * @return array
         */
        public static function findAllFiltered($conditions = null)
        {
            $reflectionClass = new \ReflectionClass(static::className());
            $modelClassShortName = $reflectionClass->getShortName();
            $filteredModels = [];
            try {
                foreach ((is_array($conditions)) ? static::find()->where($conditions)->all() : static::find()->all() as $model) {
                    if (Yii::$app->user->can('view' . $modelClassShortName, ['modelId' => $model->id])) {
                        $filteredModels[] = $model;
                    }
                }
            } catch (Exception $ex) {
                throw $ex;
            }
            return $filteredModels;
        }

        public function getCreatedAt()
        {
            return date('M j Y h:i A', strtotime($this->created_at));
        }

        public function getUpdatedAt()
        {
            return date('M j Y h:i A', strtotime($this->updated_at));
        }
    }