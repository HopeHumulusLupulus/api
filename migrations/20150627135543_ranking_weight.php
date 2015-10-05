<?php

use Phinx\Migration\AbstractMigration;

class RankingWeight extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $pin_ranking_type = $this->table('pin_ranking_type')
            ->addColumn('weight', 'integer', array('null' => true))
            ->addColumn('enabled', 'boolean', array('null' => true));
        $pin_ranking_type->save();

        $this->execute("UPDATE pin_ranking_type SET weight = 1, enabled = false;");
        $this->execute("UPDATE pin_ranking_type SET weight = 10, enabled = true WHERE code = 'variety_food';");
        $this->execute("UPDATE pin_ranking_type SET weight = 30, enabled = true WHERE code = 'variety_beer';");
        $this->execute("UPDATE pin_ranking_type SET weight = 30, enabled = true WHERE code = 'service';");
        $this->execute("UPDATE pin_ranking_type SET weight = 20, enabled = true WHERE code = 'ambience';");
        $this->execute("UPDATE pin_ranking_type SET weight = 10, enabled = true WHERE code = 'price';");

        $pin_ranking_type
            ->changeColumn('weight', 'integer')
            ->changeColumn('enabled', 'boolean');
        $pin_ranking_type->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $this->table('pin_ranking_type')
            ->removeColumn('weight')
            ->removeColumn('enabled')
            ->save();

    }
}