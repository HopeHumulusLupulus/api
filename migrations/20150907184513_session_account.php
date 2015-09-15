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
        $session_user_account = $this->table('session_user_account');
        $session_user_account
            ->addColumn('id_user_account', 'integer')
            ->addColumn('method', 'enum', array('values' => array('email-token')))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_user_account', $user_account, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
    }
}
