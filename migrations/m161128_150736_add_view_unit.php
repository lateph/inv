<?php

use yii\db\Migration;

class m161128_150736_add_view_unit extends Migration
{
    public function up()
    {
        $this->execute("create view unit_gudang as select unit.kode_unit as kode_unit from unit UNION select 'G001'
");
    }

    public function down()
    {
        $this->execute("drop view unit_gudang");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
