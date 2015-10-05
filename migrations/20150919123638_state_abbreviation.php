<?php

use Phinx\Migration\AbstractMigration;

class StateAbbreviation extends AbstractMigration
{
    public function up()
    {
        $state = $this->table('state')
            ->addColumn('abbreviation', 'string', array('limit' => 2, 'null' => true));
        $state->save();
    	
    	$this->execute("
            UPDATE state SET abbreviation='AL' WHERE id = 2;
            UPDATE state SET abbreviation='AP' WHERE id = 3;
            UPDATE state SET abbreviation='AM' WHERE id = 4;
            UPDATE state SET abbreviation='BA' WHERE id = 5;
            UPDATE state SET abbreviation='CE' WHERE id = 6;
            UPDATE state SET abbreviation='AC' WHERE id = 1;
            UPDATE state SET abbreviation='DF' WHERE id = 7;
            UPDATE state SET abbreviation='ES' WHERE id = 8;
            UPDATE state SET abbreviation='GO' WHERE id = 9;
            UPDATE state SET abbreviation='MA' WHERE id = 10;
            UPDATE state SET abbreviation='MT' WHERE id = 11;
            UPDATE state SET abbreviation='MS' WHERE id = 12;
            UPDATE state SET abbreviation='MG' WHERE id = 13;
            UPDATE state SET abbreviation='PA' WHERE id = 14;
            UPDATE state SET abbreviation='PB' WHERE id = 15;
            UPDATE state SET abbreviation='PR' WHERE id = 16;
            UPDATE state SET abbreviation='PE' WHERE id = 17;
            UPDATE state SET abbreviation='PI' WHERE id = 18;
            UPDATE state SET abbreviation='RJ' WHERE id = 19;
            UPDATE state SET abbreviation='RN' WHERE id = 20;
            UPDATE state SET abbreviation='RS' WHERE id = 21;
            UPDATE state SET abbreviation='RO' WHERE id = 22;
            UPDATE state SET abbreviation='RR' WHERE id = 23;
            UPDATE state SET abbreviation='SC' WHERE id = 24;
            UPDATE state SET abbreviation='SP' WHERE id = 25;
            UPDATE state SET abbreviation='SE' WHERE id = 26;
            INSERT INTO state (name, id_country, abbreviation) VALUES ('Tocantins', 1, 'TO');
        ");
        $state = $this->table('state')
            ->changeColumn('abbreviation', 'string', array('limit' => 2, 'null' => false));
        $state->save();
    }

    public function down()
    {
        $this->execute("DELETE FROM state WHERE abbreviation = 'TO';");

        $state = $this->table('state')
            ->removeColumn('abbreviation');
        $state->save();
    }
}
