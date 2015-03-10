<?php

use Phinx\Migration\AbstractMigration;

class Ranking extends AbstractMigration
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
        $pin_ranking = $this->table('pin_ranking_type')
            ->addColumn('type', 'string', array('limit' => 150))
            ->addColumn('code', 'string', array('limit' => 20))
            ->save();

        $pin_ranking = $this->table('pin_ranking')
            ->addColumn('id_pin', 'integer')
            ->addColumn('id_user_account', 'integer')
            ->addColumn('id_pin_ranking_type', 'integer')
            ->addColumn('ranking', 'integer')
            ->addColumn('last', 'integer', array('default' => 1))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_pin', 'pin', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_user_account', 'user_account', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_pin_ranking_type', 'pin_ranking_type', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin_ranking->save();

        $pin_checkin = $this->table('pin_checkin')
            ->addColumn('id_pin', 'integer')
            ->addColumn('id_user_account', 'integer')
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_pin', 'pin', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_user_account', 'user_account', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin_checkin->save();

        $this->execute("
            INSERT INTO pin_ranking_type (type, code) VALUES ('geral', 'general');
            INSERT INTO pin_ranking_type (type, code) VALUES ('preço', 'price');
            INSERT INTO pin_ranking_type (type, code) VALUES ('variedade de chope', 'variety_chopp');
            INSERT INTO pin_ranking_type (type, code) VALUES ('variedade de cerveja', 'variety_beer');
            INSERT INTO pin_ranking_type (type, code) VALUES ('variedade de comida', 'variety_food');
        ");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('pin_ranking');
    }
}