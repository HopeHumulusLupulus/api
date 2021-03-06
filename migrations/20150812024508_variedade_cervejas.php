<?php

use Phinx\Migration\AbstractMigration;

class VariedadeCervejas extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function up()
    {
        $this->execute("UPDATE pin_ranking_type SET type= 'Variedade de cerveja' WHERE code = 'variety_beer';");
        $this->execute("UPDATE phone_pin SET number = CONCAT('+55', number)");
    }

    public function down()
    {
        $this->execute("UPDATE pin_ranking_type SET type= 'variedade de cerveja' WHERE code = 'variety_beer';");
        $this->execute("UPDATE phone_pin SET number = substr(number, 4)");
    }
}
