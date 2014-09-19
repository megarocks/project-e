<?php

    use app\models\System;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140919_101256_add_system_status_unassigned extends Migration
    {
        public function up()
        {
            $systems = System::find()->all();
            $tmpSystems = [];
            foreach ($systems as $system) {
                switch ($system->status) {
                    case System::STATUS_UNASSIGNED:
                        $system->status = 0;
                        break;
                    case System::STATUS_UNLOCKED:
                        $system->status = 1;
                        break;
                    case System::STATUS_ACTIVE:
                        $system->status = 2;
                        break;
                    case System::STATUS_ACTIVE_PAYMENT:
                        $system->status = 3;
                        break;
                    case System::STATUS_LOCKED:
                        $system->status = 4;
                        break;
                }
                $tmpSystems[] = $system;
            }
            if ($this->alterColumn('systems', 'status', 'INT(2)')) {
                foreach ($tmpSystems as $system) {
                    $system->save();
                }
            }

        }

        public function down()
        {
            echo "m140919_101256_add_system_status_unassigned cannot be reverted.\n";

            return false;
        }
    }
