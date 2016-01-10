<?php

use Phinx\Migration\AbstractMigration;

class FixPinLatLng extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->table('pin')
            ->changeColumn('lat', 'decimal', array('precision' => 10, 'scale' => 2))
            ->changeColumn('lng', 'decimal', array('precision' => 10, 'scale' => 2))
            ->save();
    }

    public function down()
    {
        $this->table('pin')
            ->changeColumn('lat', 'float')
            ->changeColumn('lng', 'float')
            ->save();
    }
}
