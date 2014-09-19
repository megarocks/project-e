<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140919_152633_po_monetary_values extends Migration
    {
        public function up()
        {
            $this->alterColumn('po', 'cpup', 'decimal(10,2)');
            $this->alterColumn('po', 'dpup', 'decimal(10,2)');
            $this->alterColumn('po', 'dsp', 'decimal(10,2)');
            $this->alterColumn('po', 'csp', 'decimal(10,2)');
            $this->alterColumn('po', 'cmp', 'decimal(10,2)');
            $this->alterColumn('po', 'dmp', 'decimal(10,2)');
            $this->alterColumn('po', 'ctpl', 'decimal(10,2)');
            $this->alterColumn('po', 'dtpl', 'decimal(10,2)');
        }

        public function down()
        {
            echo "m140919_152633_po_monetary_values cannot be reverted.\n";

            return false;
        }
    }
