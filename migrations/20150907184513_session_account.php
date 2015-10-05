<?php

use Phinx\Migration\AbstractMigration;

class SessionAccount extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
        $session_user_account = $this->table('session_user_account');
        $session_user_account
            ->addColumn('id_user_account', 'integer')
            ->addColumn('method', 'enum', array('values' => array('email-token', 'sms-token', 'password')))
            ->addColumn('token', 'char', array('limit' => 7, 'null' => true))
            ->addColumn('attempts', 'integer', array('default' => 0))
            ->addColumn('access_token', 'char', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('authenticated', 'datetime', array('null' => true))
            ->addForeignKey('id_user_account', 'user_account', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $session_user_account->save();
    }
}
