<?php

use Phinx\Migration\AbstractMigration;

class UserPassword extends AbstractMigration
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
        $this->table('user_account')
            ->addColumn('password', 'string', array('null' => true, 'length' => 60))
            ->addColumn('deleted', 'datetime', array('null' => true))
            ->save();
    }
}
