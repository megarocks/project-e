<?php
    namespace app\widgets;

    use yii\bootstrap\Widget;

    class LoginForm extends Widget
    {
        public $formType;
        public $model;

        public function run()
        {
            return $this->render($this->formType . '-form', [
                    'model' => $this->model,
                ]);
        }

    }
