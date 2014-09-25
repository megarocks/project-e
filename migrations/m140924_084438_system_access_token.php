<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140924_084438_system_access_token extends Migration
    {
        public function up()
        {
            $this->addColumn('systems', 'access_token', 'VARCHAR(64)');
            $security = new \yii\base\Security();
            foreach (\app\models\System::find()->all() as $system) {
                $system->access_token = $security->generateRandomString();
                $system->save();
            }
        }

        public function down()
        {
            echo "m140924_084438_system_access_token cannot be reverted.\n";

            return false;
        }
    }
