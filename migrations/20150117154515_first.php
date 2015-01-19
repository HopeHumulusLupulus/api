<?php

use Phinx\Migration\AbstractMigration;

class First extends AbstractMigration
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
        $country = $this->table('country')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'));
        $country->save();

        $state = $this->table('state')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('id_country', 'integer')
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_country', $country, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $state->save();

        $city = $this->table('city')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('id_state', 'integer')
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_state', $state, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $city->save();

        $district = $this->table('district')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('id_city', 'integer')
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_city', $city, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $district->save();

        $pin = $this->table('pin')
            ->addColumn('id_district', 'integer')
            ->addColumn('name', 'string', array('limit' => 50))
            ->addColumn('lat', 'integer')
            ->addColumn('lng', 'integer')
            ->addColumn('address', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('link', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_district', $district, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->save();

        $this->execute("INSERT INTO country (name) VALUES('Brasil')");
        $this->execute("INSERT INTO state (name, id_country) VALUES('Rio de Janeiro', 1);");
        $this->execute("
            INSERT INTO city (id_state,name) VALUES (1,'Búzios');
            INSERT INTO city (id_state,name) VALUES (1,'Macaé');
            INSERT INTO city (id_state,name) VALUES (1,'Niterói');
            INSERT INTO city (id_state,name) VALUES (1,'Petrópolis');
            INSERT INTO city (id_state,name) VALUES (1,'Resende');
            INSERT INTO city (id_state,name) VALUES (1,'Rio de Janeiro');
            INSERT INTO city (id_state,name) VALUES (1,'Teresópolis');
            INSERT INTO city (id_state,name) VALUES (1,'Volta Redonda');
            
            INSERT INTO district (name,id_city) VALUES ('Alto',7);
INSERT INTO district (name,id_city) VALUES ('Anil',6);
INSERT INTO district (name,id_city) VALUES ('Aterrado',8);
INSERT INTO district (name,id_city) VALUES ('Barra da Tijuca',6);
INSERT INTO district (name,id_city) VALUES ('Benfica',6);
INSERT INTO district (name,id_city) VALUES ('Botafogo',6);
INSERT INTO district (name,id_city) VALUES ('Cachambi',6);
INSERT INTO district (name,id_city) VALUES ('Centro',6);
INSERT INTO district (name,id_city) VALUES ('Cidade Nova',6);
INSERT INTO district (name,id_city) VALUES ('Copacabana',6);
INSERT INTO district (name,id_city) VALUES ('Cosme Velho',6);
INSERT INTO district (name,id_city) VALUES ('Del Castilho',6);
INSERT INTO district (name,id_city) VALUES ('Flamengo',6);
INSERT INTO district (name,id_city) VALUES ('Humaitá',6);
INSERT INTO district (name,id_city) VALUES ('Icaraí',3);
INSERT INTO district (name,id_city) VALUES ('Ipanema',6);
INSERT INTO district (name,id_city) VALUES ('Itaboraí',3);
INSERT INTO district (name,id_city) VALUES ('Itaipu',3);
INSERT INTO district (name,id_city) VALUES ('Jacarepaguá',6);
INSERT INTO district (name,id_city) VALUES ('Jardim Botânico',6);
INSERT INTO district (name,id_city) VALUES ('Jardim Icaraí',3);
INSERT INTO district (name,id_city) VALUES ('Lagomar',2);
INSERT INTO district (name,id_city) VALUES ('Lapa',6);
INSERT INTO district (name,id_city) VALUES ('Laranjeiras',6);
INSERT INTO district (name,id_city) VALUES ('Largo do Machado',6);
INSERT INTO district (name,id_city) VALUES ('Leblon',6);
INSERT INTO district (name,id_city) VALUES ('Lot. Triângulo de Búzios',1);
INSERT INTO district (name,id_city) VALUES ('Mosela',4);
INSERT INTO district (name,id_city) VALUES ('Olaria',6);
INSERT INTO district (name,id_city) VALUES ('Paraíso',5);
INSERT INTO district (name,id_city) VALUES ('Pilares',6);
INSERT INTO district (name,id_city) VALUES ('Praça da Bandeira',6);
INSERT INTO district (name,id_city) VALUES ('Praça Mauá',6);
INSERT INTO district (name,id_city) VALUES ('Recreio',6);
INSERT INTO district (name,id_city) VALUES ('Santa Teresa',6);
INSERT INTO district (name,id_city) VALUES ('Santo Cristo',6);
INSERT INTO district (name,id_city) VALUES ('São Francisco',3);
INSERT INTO district (name,id_city) VALUES ('Taquara',6);
INSERT INTO district (name,id_city) VALUES ('Tijuca',6);
INSERT INTO district (name,id_city) VALUES ('Todos os Santos',6);");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('pin');
        $this->dropTable('district');
        $this->dropTable('city');
        $this->dropTable('state');
        $this->dropTable('country');
    }
}