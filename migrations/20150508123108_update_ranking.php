<?php

use Phinx\Migration\AbstractMigration;

class UpdateRanking extends AbstractMigration
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
        $this->execute("
            UPDATE pin_ranking_type SET type = 'Comidas/Petiscos' WHERE code = 'variety_food';
            UPDATE pin_ranking_type SET type = 'Variedade de cerveja' WHERE code = 'variety_chopp';
            INSERT INTO pin_ranking_type (type, code) VALUES ('Atendimento/Serviço', 'service');
            INSERT INTO pin_ranking_type (type, code) VALUES ('Ambiente/Higiene', 'ambience');
            UPDATE pin_ranking_type SET type = 'Nível de sofisticação' WHERE code = 'price';
        ");

        $pin_checkin = $this->table('pin_comment')
        ->addColumn('id_pin', 'integer')
        ->addColumn('id_user_account', 'integer')
        ->addColumn('type', 'text')
        ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
        ->addForeignKey('id_pin', 'pin', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
        ->addForeignKey('id_user_account', 'user_account', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin_checkin->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $this->execute("
            UPDATE pin_ranking_type SET type = 'variedade de comida' WHERE code = 'variety_food';
            UPDATE pin_ranking_type SET type = 'variedade de chope' WHERE code = 'variety_chopp';
            DELETE FROM pin_ranking_type WHERE code = 'service';
            DELETE FROM pin_ranking_type WHERE code = 'ambience';
            UPDATE pin_ranking_type SET type = 'preço' WHERE code = 'price';
        ");
        $this->dropTable('pin_comment');
    }
}