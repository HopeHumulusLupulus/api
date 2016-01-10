<?php

use Phinx\Migration\AbstractMigration;

class PinComment extends AbstractMigration
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
        $this->table('pin')
            ->addColumn('comments', 'text', array('null' => true))
            ->save();
    }

    public function down()
    {

    }
}
