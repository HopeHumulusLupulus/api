<?php

use Phinx\Migration\AbstractMigration;

class UserAccount extends AbstractMigration
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
    	$user_account = $this->table('user_account')
	    	->addColumn('gender', 'string', array('limit' => 1,'null' => true))
	    	->addColumn('birth', 'date', array('null' => true));
    	$user_account->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $schema = getenv('PHINX_SCHEMA');
        $this->query('SET search_path TO '.$schema);
    	$user_account = $this->table('user_account')
    		->removeColumn('gender')
    		->removeColumn('birth');
    }
}