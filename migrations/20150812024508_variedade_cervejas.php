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
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $this->execute("UPDATE pin_ranking_type SET type= 'Variedade de cerveja' WHERE code = 'variety_beer';");
    }

    public function down()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $this->execute("UPDATE pin_ranking_type SET type= 'variedade de cerveja' WHERE code = 'variety_beer';");
    }
}
