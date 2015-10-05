<?php

use Phinx\Migration\AbstractMigration;

class Contact extends AbstractMigration
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
        $contact = $this->table('contact')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('email', 'string', array('limit' => 50))
            ->addColumn('message', 'text')
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'));
        $contact->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $this->dropTable('contact');
    }
}