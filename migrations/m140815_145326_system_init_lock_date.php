<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140815_145326_system_init_lock_date extends Migration
    {
        public function up()
        {
            $this->addColumn('systems', 'init_lock_date', 'date');
        }

        public function down()
        {
            $this->dropColumn('systems', 'init_lock_date', 'date');
        }
    }
