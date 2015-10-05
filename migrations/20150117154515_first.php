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
            ->addColumn('id_country', 'integer')
            ->addColumn('id_state', 'integer')
            ->addColumn('id_city', 'integer', array('null' => true))
            ->addColumn('id_district', 'integer', array('null' => true))
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('lat', 'float')
            ->addColumn('lng', 'float')
            ->addColumn('address', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('link', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('enabled', 'datetime', array('null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('created_by', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('enabled_by', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('deleted', 'datetime', array('null' => true))
            ->addForeignKey('id_country', $country, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_state', $state, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_city', $city, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_district', $district, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin->save();

        $phone_type = $this->table('phone_type')
            ->addColumn('type', 'string', array('limit' => 15));
        $phone_type->save();

        $phone = $this->table('phone_pin')
            ->addColumn('id_phone_type', 'integer')
            ->addColumn('number', 'string', array('limit' => 15))
            ->addColumn('id_pin', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_phone_type', $phone_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_pin', $pin, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $phone->save();

        $user_account = $this->table('user_account')
            ->addColumn('name', 'string', array('limit' => 150))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'));
        $user_account->save();

        $phone_user_account = $this->table('phone_user_account')
            ->addColumn('id_phone_type', 'integer', array('default' => 2))
            ->addColumn('number', 'string', array('limit' => 15))
            ->addColumn('id_user_account', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_phone_type', $phone_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_user_account', $user_account, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $phone_user_account->save();

        $email_type = $this->table('email_type')
            ->addColumn('type', 'string', array('limit' => 15));
        $email_type->save();

        $email_user_account = $this->table('email_user_account')
            ->addColumn('id_email_type', 'integer', array('default' => 2))
            ->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('id_user_account', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_email_type', $email_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_user_account', $user_account, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $email_user_account->save();

        $address_type = $this->table('address_type')
            ->addColumn('type', 'string', array('limit' => 15));
        $address_type->save();

        $address_user_account = $this->table('address_user_account')
            ->addColumn('id_country', 'integer')
            ->addColumn('id_state', 'integer')
            ->addColumn('id_city', 'integer', array('null' => true))
            ->addColumn('id_district', 'integer', array('null' => true))
            ->addColumn('id_address_type', 'integer')
            ->addColumn('address', 'string', array('limit' => 15))
            ->addColumn('id_user_account', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_address_type', $address_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_user_account', $user_account, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_country', $country, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_state', $state, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_city', $city, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('id_district', $district, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $address_user_account->save();

        $this->execute("
/* tabela de importação
CREATE TABLE importacao (
  id serial NOT NULL,
  estado varchar(100) DEFAULT NULL,
  municipio varchar(100) DEFAULT NULL,
  bairro varchar(100) DEFAULT NULL,
  nome varchar(100) DEFAULT NULL,
  pin varchar(100) DEFAULT NULL,
  endereco varchar(200) DEFAULT NULL,
  telefone varchar(45) DEFAULT NULL,
  link varchar(100) DEFAULT NULL,
  seg1 varchar(45) DEFAULT NULL,
  seg2 varchar(45) DEFAULT NULL,
  ter1 varchar(45) DEFAULT NULL,
  ter2 varchar(45) DEFAULT NULL,
  qua1 varchar(45) DEFAULT NULL,
  qua2 varchar(45) DEFAULT NULL,
  qui1 varchar(45) DEFAULT NULL,
  qui2 varchar(45) DEFAULT NULL,
  sex1 varchar(45) DEFAULT NULL,
  sex2 varchar(45) DEFAULT NULL,
  sab1 varchar(45) DEFAULT NULL,
  sab2 varchar(45) DEFAULT NULL,
  dom1 varchar(45) DEFAULT NULL,
  dom2 varchar(45) DEFAULT NULL,
  local varchar(45) DEFAULT NULL,
  chope varchar(45) DEFAULT NULL,
  cerveja varchar(45) DEFAULT NULL,
  cg varchar(45) DEFAULT NULL,
  cp varchar(45) DEFAULT NULL,
  comida varchar(45) DEFAULT NULL,
  PRIMARY KEY (id)
);
*/

INSERT INTO country (name) VALUES('Brasil');
SELECT setval('country_id_seq', (SELECT MAX(id) FROM country));

/*
INSERT INTO state(name, id_country)
SELECT TRIM(i.estado), 1
  FROM importacao i
  LEFT JOIN state s ON s.name = TRIM(i.estado)
 WHERE s.id IS NULL
 GROUP BY i.estado
 ORDER BY i.estado;
*/

INSERT INTO state (id,name,id_country) VALUES (1,'Acre',1);
INSERT INTO state (id,name,id_country) VALUES (2,'Alagoas',1);
INSERT INTO state (id,name,id_country) VALUES (3,'Amapá',1);
INSERT INTO state (id,name,id_country) VALUES (4,'Amazônia',1);
INSERT INTO state (id,name,id_country) VALUES (5,'Bahia',1);
INSERT INTO state (id,name,id_country) VALUES (6,'Ceará',1);
INSERT INTO state (id,name,id_country) VALUES (7,'Distrito Federal',1);
INSERT INTO state (id,name,id_country) VALUES (8,'Espírito Santo',1);
INSERT INTO state (id,name,id_country) VALUES (9,'Goiás',1);
INSERT INTO state (id,name,id_country) VALUES (10,'Maranhão',1);
INSERT INTO state (id,name,id_country) VALUES (11,'Mato Grosso',1);
INSERT INTO state (id,name,id_country) VALUES (12,'Mato Grosso do Sul',1);
INSERT INTO state (id,name,id_country) VALUES (13,'Minas Gerais',1);
INSERT INTO state (id,name,id_country) VALUES (14,'Pará',1);
INSERT INTO state (id,name,id_country) VALUES (15,'Paraíba',1);
INSERT INTO state (id,name,id_country) VALUES (16,'Paraná',1);
INSERT INTO state (id,name,id_country) VALUES (17,'Pernambuco',1);
INSERT INTO state (id,name,id_country) VALUES (18,'Piauí',1);
INSERT INTO state (id,name,id_country) VALUES (19,'Rio de Janeiro',1);
INSERT INTO state (id,name,id_country) VALUES (20,'Rio Grande do Norte',1);
INSERT INTO state (id,name,id_country) VALUES (21,'Rio Grande do Sul',1);
INSERT INTO state (id,name,id_country) VALUES (22,'Rondônia',1);
INSERT INTO state (id,name,id_country) VALUES (23,'Roraíma',1);
INSERT INTO state (id,name,id_country) VALUES (24,'Santa Catarina',1);
INSERT INTO state (id,name,id_country) VALUES (25,'São Paulo',1);
INSERT INTO state (id,name,id_country) VALUES (26,'Sergipe',1);
SELECT setval('state_id_seq', (SELECT MAX(id) FROM state));

/*
INSERT INTO city(name, id_state)
SELECT TRIM(i.municipio), s.id
  FROM importacao i
  LEFT JOIN city c ON c.name = TRIM(i.municipio)
  JOIN state s ON s.name = TRIM(i.estado)
 WHERE c.id IS NULL
 GROUP BY i.municipio, s.id
 ORDER BY s.id, i.municipio;
*/

INSERT INTO city (id,name,id_state) VALUES (1,'Rio Branco',1);
INSERT INTO city (id,name,id_state) VALUES (2,'Maceió',2);
INSERT INTO city (id,name,id_state) VALUES (3,'Macapá',3);
INSERT INTO city (id,name,id_state) VALUES (4,'Manaus',4);
INSERT INTO city (id,name,id_state) VALUES (5,'Lauro de Freitas',5);
INSERT INTO city (id,name,id_state) VALUES (6,'Salvador',5);
INSERT INTO city (id,name,id_state) VALUES (7,'Fortaleza',6);
INSERT INTO city (id,name,id_state) VALUES (8,'Brasília',7);
INSERT INTO city (id,name,id_state) VALUES (9,'Vila Velha',8);
INSERT INTO city (id,name,id_state) VALUES (10,'Vitória',8);
INSERT INTO city (id,name,id_state) VALUES (11,'Goiânia',9);
INSERT INTO city (id,name,id_state) VALUES (12,'São Luiz',10);
INSERT INTO city (id,name,id_state) VALUES (13,'Cuiabá',11);
INSERT INTO city (id,name,id_state) VALUES (14,'Rondonópolis',11);
INSERT INTO city (id,name,id_state) VALUES (15,'Campo Grande',12);
INSERT INTO city (id,name,id_state) VALUES (16,'Belo Horizonte',13);
INSERT INTO city (id,name,id_state) VALUES (17,'Ipatinga',13);
INSERT INTO city (id,name,id_state) VALUES (18,'São Lourenço',13);
INSERT INTO city (id,name,id_state) VALUES (19,'Uberlândia',13);
INSERT INTO city (id,name,id_state) VALUES (20,'Belém',14);
INSERT INTO city (id,name,id_state) VALUES (21,'João Pessoa',15);
INSERT INTO city (id,name,id_state) VALUES (22,'Cáscavel',16);
INSERT INTO city (id,name,id_state) VALUES (23,'Cascável',16);
INSERT INTO city (id,name,id_state) VALUES (24,'Curitiba',16);
INSERT INTO city (id,name,id_state) VALUES (25,'Guarapuava',16);
INSERT INTO city (id,name,id_state) VALUES (26,'Londrina',16);
INSERT INTO city (id,name,id_state) VALUES (27,'Maringá',16);
INSERT INTO city (id,name,id_state) VALUES (28,'Ponta Grossa',16);
INSERT INTO city (id,name,id_state) VALUES (29,'Recife',17);
INSERT INTO city (id,name,id_state) VALUES (30,'Teresina',18);
INSERT INTO city (id,name,id_state) VALUES (31,'Búzios',19);
INSERT INTO city (id,name,id_state) VALUES (32,'Macaé',19);
INSERT INTO city (id,name,id_state) VALUES (33,'Niterói',19);
INSERT INTO city (id,name,id_state) VALUES (34,'Petrópolis',19);
INSERT INTO city (id,name,id_state) VALUES (35,'Resende',19);
INSERT INTO city (id,name,id_state) VALUES (36,'Rio de Janeiro',19);
INSERT INTO city (id,name,id_state) VALUES (37,'São Gonçalo',19);
INSERT INTO city (id,name,id_state) VALUES (38,'Teresópolis',19);
INSERT INTO city (id,name,id_state) VALUES (39,'Volta Redonda',19);
INSERT INTO city (id,name,id_state) VALUES (40,'Natal',20);
INSERT INTO city (id,name,id_state) VALUES (41,'Canela',21);
INSERT INTO city (id,name,id_state) VALUES (42,'Ivoti',21);
INSERT INTO city (id,name,id_state) VALUES (43,'Nova Petrópolis',21);
INSERT INTO city (id,name,id_state) VALUES (44,'Novo Hamburgo',21);
INSERT INTO city (id,name,id_state) VALUES (45,'Porto Alegre',21);
INSERT INTO city (id,name,id_state) VALUES (46,'Porto Velho',22);
INSERT INTO city (id,name,id_state) VALUES (47,'Boa Vista',23);
INSERT INTO city (id,name,id_state) VALUES (48,'Balneário Camboriú',24);
INSERT INTO city (id,name,id_state) VALUES (49,'Blumenau',24);
INSERT INTO city (id,name,id_state) VALUES (50,'Gaspar',24);
INSERT INTO city (id,name,id_state) VALUES (51,'Joinville',24);
INSERT INTO city (id,name,id_state) VALUES (52,'Pomerode',24);
INSERT INTO city (id,name,id_state) VALUES (53,'Treze Tílias',24);
INSERT INTO city (id,name,id_state) VALUES (54,'Araraquara',25);
INSERT INTO city (id,name,id_state) VALUES (55,'Barueri',25);
INSERT INTO city (id,name,id_state) VALUES (56,'Campinas',25);
INSERT INTO city (id,name,id_state) VALUES (57,'Campos do Jordão',25);
INSERT INTO city (id,name,id_state) VALUES (58,'Caraguatatuba',25);
INSERT INTO city (id,name,id_state) VALUES (59,'Cotia',25);
INSERT INTO city (id,name,id_state) VALUES (60,'Guarulhos',25);
INSERT INTO city (id,name,id_state) VALUES (61,'Holambra',25);
INSERT INTO city (id,name,id_state) VALUES (62,'Indaiatuba',25);
INSERT INTO city (id,name,id_state) VALUES (63,'Itapeva',25);
INSERT INTO city (id,name,id_state) VALUES (64,'Itu',25);
INSERT INTO city (id,name,id_state) VALUES (65,'Jundiaí',25);
INSERT INTO city (id,name,id_state) VALUES (66,'Mogi Das Cruzes',25);
INSERT INTO city (id,name,id_state) VALUES (67,'Osasco',25);
INSERT INTO city (id,name,id_state) VALUES (68,'Peruíbe',25);
INSERT INTO city (id,name,id_state) VALUES (69,'Piracicaba',25);
INSERT INTO city (id,name,id_state) VALUES (70,'Ribeirão Preto',25);
INSERT INTO city (id,name,id_state) VALUES (71,'Santo André',25);
INSERT INTO city (id,name,id_state) VALUES (72,'São Bernardo Do Campo',25);
INSERT INTO city (id,name,id_state) VALUES (73,'São Carlos',25);
INSERT INTO city (id,name,id_state) VALUES (74,'São João Da Boa Vista',25);
INSERT INTO city (id,name,id_state) VALUES (75,'São José do Rio Preto',25);
INSERT INTO city (id,name,id_state) VALUES (76,'São José Do Rio Preto',25);
INSERT INTO city (id,name,id_state) VALUES (77,'São José Dos Campos',25);
INSERT INTO city (id,name,id_state) VALUES (78,'São Paulo',25);
INSERT INTO city (id,name,id_state) VALUES (79,'Sorocaba',25);
INSERT INTO city (id,name,id_state) VALUES (80,'Votorantim',25);
INSERT INTO city (id,name,id_state) VALUES (81,'Aracajú',26);
INSERT INTO city (id,name,id_state) VALUES (82,'Penedo',19);
INSERT INTO city (id,name,id_state) VALUES (83,'Rio das Ostras',19);
INSERT INTO city (id,name,id_state) VALUES (84,'Vassouras',19);
SELECT setval('city_id_seq', (SELECT MAX(id) FROM city));

/*
INSERT INTO district(name, id_city)
SELECT TRIM(i.bairro), c.id
  FROM importacao i
  JOIN city c ON c.name = TRIM(i.municipio)
  LEFT JOIN district d ON d.name = i.bairro
 WHERE d.id IS NULL
 GROUP BY i.bairro, c.id
 ORDER BY c.id, i.bairro;
*/

INSERT INTO district (id,name,id_city) VALUES (1,'Bosque',1);
INSERT INTO district (id,name,id_city) VALUES (2,'Cruz das Almas',2);
INSERT INTO district (id,name,id_city) VALUES (3,'Jatiúca',2);
INSERT INTO district (id,name,id_city) VALUES (4,'Trem',3);
INSERT INTO district (id,name,id_city) VALUES (5,'Adrianópolis',4);
INSERT INTO district (id,name,id_city) VALUES (6,'Centro',4);
INSERT INTO district (id,name,id_city) VALUES (7,'Flores',4);
INSERT INTO district (id,name,id_city) VALUES (8,'Nossa Senhora das Graças',4);
INSERT INTO district (id,name,id_city) VALUES (9,'Parque Dez de Novembro',4);
INSERT INTO district (id,name,id_city) VALUES (10,'Santo Agostinho',4);
INSERT INTO district (id,name,id_city) VALUES (11,'Santo Antônio',4);
INSERT INTO district (id,name,id_city) VALUES (12,'Tarumã',4);
INSERT INTO district (id,name,id_city) VALUES (13,'Vilas do Atlântico',5);
INSERT INTO district (id,name,id_city) VALUES (14,'Caminho das Árvores',6);
INSERT INTO district (id,name,id_city) VALUES (15,'Jaguaribe',6);
INSERT INTO district (id,name,id_city) VALUES (16,'Paralela',6);
INSERT INTO district (id,name,id_city) VALUES (17,'Pituba',6);
INSERT INTO district (id,name,id_city) VALUES (18,'Rio Vermelho',6);
INSERT INTO district (id,name,id_city) VALUES (19,'Aldeota',7);
INSERT INTO district (id,name,id_city) VALUES (20,'Aeroporto',8);
INSERT INTO district (id,name,id_city) VALUES (21,'Águas Claras',8);
INSERT INTO district (id,name,id_city) VALUES (22,'Asa Norte',8);
INSERT INTO district (id,name,id_city) VALUES (23,'Asa Sul',8);
INSERT INTO district (id,name,id_city) VALUES (24,'Setor Sudoeste',8);
INSERT INTO district (id,name,id_city) VALUES (25,'Sudoeste',8);
INSERT INTO district (id,name,id_city) VALUES (26,'Zona Industrial',8);
INSERT INTO district (id,name,id_city) VALUES (27,'Centro',9);
INSERT INTO district (id,name,id_city) VALUES (28,'Enseada do Suá',10);
INSERT INTO district (id,name,id_city) VALUES (29,'Praia do Canto',10);
INSERT INTO district (id,name,id_city) VALUES (30,'Jardim América',11);
INSERT INTO district (id,name,id_city) VALUES (31,'Jardim Goiás',11);
INSERT INTO district (id,name,id_city) VALUES (32,'Setor Bueno',11);
INSERT INTO district (id,name,id_city) VALUES (33,'Setor Marista',11);
INSERT INTO district (id,name,id_city) VALUES (34,'Setor Oeste',11);
INSERT INTO district (id,name,id_city) VALUES (35,'Setor Sul',11);
INSERT INTO district (id,name,id_city) VALUES (36,'Setor Universitário',11);
INSERT INTO district (id,name,id_city) VALUES (37,'Vila São Francisco',11);
INSERT INTO district (id,name,id_city) VALUES (38,'Ponta do Farol',12);
INSERT INTO district (id,name,id_city) VALUES (39,'Centro Norte',13);
INSERT INTO district (id,name,id_city) VALUES (40,'Dom Aquino',13);
INSERT INTO district (id,name,id_city) VALUES (41,'Duque de Caxias',13);
INSERT INTO district (id,name,id_city) VALUES (42,'Popular',13);
INSERT INTO district (id,name,id_city) VALUES (43,'Quilombo',13);
INSERT INTO district (id,name,id_city) VALUES (44,'Santa Helena',13);
INSERT INTO district (id,name,id_city) VALUES (45,'Sagrada Família',14);
INSERT INTO district (id,name,id_city) VALUES (46,'Centro',15);
INSERT INTO district (id,name,id_city) VALUES (47,'Jardim Aclimação',15);
INSERT INTO district (id,name,id_city) VALUES (48,'Novos Estados',15);
INSERT INTO district (id,name,id_city) VALUES (49,'Núcleo Industrial',15);
INSERT INTO district (id,name,id_city) VALUES (50,'Anchieta',16);
INSERT INTO district (id,name,id_city) VALUES (51,'Cabral',16);
INSERT INTO district (id,name,id_city) VALUES (52,'Castelo',16);
INSERT INTO district (id,name,id_city) VALUES (53,'Floresta',16);
INSERT INTO district (id,name,id_city) VALUES (54,'Funcionários',16);
INSERT INTO district (id,name,id_city) VALUES (55,'Lourdes',16);
INSERT INTO district (id,name,id_city) VALUES (56,'Luxemburgo',16);
INSERT INTO district (id,name,id_city) VALUES (57,'Prado',16);
INSERT INTO district (id,name,id_city) VALUES (58,'Sagrada Família',16);
INSERT INTO district (id,name,id_city) VALUES (59,'Santa Amelia',16);
INSERT INTO district (id,name,id_city) VALUES (60,'Santo Agostinho',16);
INSERT INTO district (id,name,id_city) VALUES (61,'São Francisco',16);
INSERT INTO district (id,name,id_city) VALUES (62,'Savassi',16);
INSERT INTO district (id,name,id_city) VALUES (63,'Horto',17);
INSERT INTO district (id,name,id_city) VALUES (64,'Centro',18);
INSERT INTO district (id,name,id_city) VALUES (65,'Centro',19);
INSERT INTO district (id,name,id_city) VALUES (66,'Morada da Colina',19);
INSERT INTO district (id,name,id_city) VALUES (67,'Nazaré',20);
INSERT INTO district (id,name,id_city) VALUES (68,'Loteamento Parque Verde',21);
INSERT INTO district (id,name,id_city) VALUES (69,'Centro',22);
INSERT INTO district (id,name,id_city) VALUES (70,'Centro',23);
INSERT INTO district (id,name,id_city) VALUES (71,'Água Verde',24);
INSERT INTO district (id,name,id_city) VALUES (72,'Bom Retiro',24);
INSERT INTO district (id,name,id_city) VALUES (73,'Centro Cívico',24);
INSERT INTO district (id,name,id_city) VALUES (74,'Mossunguê',24);
INSERT INTO district (id,name,id_city) VALUES (75,'São Francisco',24);
INSERT INTO district (id,name,id_city) VALUES (76,'Alto da XV',25);
INSERT INTO district (id,name,id_city) VALUES (77,'Gleba Palhano',26);
INSERT INTO district (id,name,id_city) VALUES (78,'Zona 01',27);
INSERT INTO district (id,name,id_city) VALUES (79,'Centro',28);
INSERT INTO district (id,name,id_city) VALUES (80,'Boa Viagem',29);
INSERT INTO district (id,name,id_city) VALUES (81,'Paranamirim',29);
INSERT INTO district (id,name,id_city) VALUES (82,'Ininga',30);
INSERT INTO district (id,name,id_city) VALUES (83,'Lot. Triângulo de Búzios',31);
INSERT INTO district (id,name,id_city) VALUES (84,'Lagomar',32);
INSERT INTO district (id,name,id_city) VALUES (85,'Icaraí',33);
INSERT INTO district (id,name,id_city) VALUES (86,'Itaboraí',33);
INSERT INTO district (id,name,id_city) VALUES (87,'Itaipu',33);
INSERT INTO district (id,name,id_city) VALUES (88,'Jardim Icaraí',33);
INSERT INTO district (id,name,id_city) VALUES (89,'Santa Rosa',33);
INSERT INTO district (id,name,id_city) VALUES (90,'São Francisco',33);
INSERT INTO district (id,name,id_city) VALUES (91,'Centro',34);
INSERT INTO district (id,name,id_city) VALUES (92,'Itaipava',34);
INSERT INTO district (id,name,id_city) VALUES (93,'Mosela',34);
INSERT INTO district (id,name,id_city) VALUES (94,'Paraíso',35);
INSERT INTO district (id,name,id_city) VALUES (95,'Anil',36);
INSERT INTO district (id,name,id_city) VALUES (96,'Barra da Tijuca',36);
INSERT INTO district (id,name,id_city) VALUES (97,'Benfica',36);
INSERT INTO district (id,name,id_city) VALUES (98,'Botafogo',36);
INSERT INTO district (id,name,id_city) VALUES (99,'Cachambi',36);
INSERT INTO district (id,name,id_city) VALUES (100,'Castelo',36);
INSERT INTO district (id,name,id_city) VALUES (101,'Centro',36);
INSERT INTO district (id,name,id_city) VALUES (102,'Cidade Nova',36);
INSERT INTO district (id,name,id_city) VALUES (103,'Copacabana',36);
INSERT INTO district (id,name,id_city) VALUES (104,'Cosme Velho',36);
INSERT INTO district (id,name,id_city) VALUES (105,'Del Castilho',36);
INSERT INTO district (id,name,id_city) VALUES (106,'Flamengo',36);
INSERT INTO district (id,name,id_city) VALUES (107,'Gávea',36);
INSERT INTO district (id,name,id_city) VALUES (108,'Humaitá',36);
INSERT INTO district (id,name,id_city) VALUES (109,'Ipanema',36);
INSERT INTO district (id,name,id_city) VALUES (110,'Jacarepaguá',36);
INSERT INTO district (id,name,id_city) VALUES (111,'Jardim Botânico',36);
INSERT INTO district (id,name,id_city) VALUES (112,'Lapa',36);
INSERT INTO district (id,name,id_city) VALUES (113,'Laranjeiras',36);
INSERT INTO district (id,name,id_city) VALUES (114,'Largo do Machado',36);
INSERT INTO district (id,name,id_city) VALUES (115,'Leblon',36);
INSERT INTO district (id,name,id_city) VALUES (116,'Olaria',36);
INSERT INTO district (id,name,id_city) VALUES (117,'Pilares',36);
INSERT INTO district (id,name,id_city) VALUES (118,'Praça da Bandeira',36);
INSERT INTO district (id,name,id_city) VALUES (119,'Praça Mauá',36);
INSERT INTO district (id,name,id_city) VALUES (120,'Recreio',36);
INSERT INTO district (id,name,id_city) VALUES (121,'Santa Teresa',36);
INSERT INTO district (id,name,id_city) VALUES (122,'Santo Cristo',36);
INSERT INTO district (id,name,id_city) VALUES (123,'Taquara',36);
INSERT INTO district (id,name,id_city) VALUES (124,'Tijuca',36);
INSERT INTO district (id,name,id_city) VALUES (125,'Todos os Santos',36);
INSERT INTO district (id,name,id_city) VALUES (126,'Centro',37);
INSERT INTO district (id,name,id_city) VALUES (127,'Alto',38);
INSERT INTO district (id,name,id_city) VALUES (128,'Várzea',38);
INSERT INTO district (id,name,id_city) VALUES (129,'Aterrado',39);
INSERT INTO district (id,name,id_city) VALUES (130,'Ponta Negra',40);
INSERT INTO district (id,name,id_city) VALUES (131,'Centro',41);
INSERT INTO district (id,name,id_city) VALUES (132,'Centro',42);
INSERT INTO district (id,name,id_city) VALUES (133,'Centro',43);
INSERT INTO district (id,name,id_city) VALUES (134,'Centro',44);
INSERT INTO district (id,name,id_city) VALUES (135,'Bela Vista',45);
INSERT INTO district (id,name,id_city) VALUES (136,'Bom Fim',45);
INSERT INTO district (id,name,id_city) VALUES (137,'Centro Histórico',45);
INSERT INTO district (id,name,id_city) VALUES (138,'Cidade Baixa',45);
INSERT INTO district (id,name,id_city) VALUES (139,'Moinhos de Vento',45);
INSERT INTO district (id,name,id_city) VALUES (140,'Mont''Serrat',45);
INSERT INTO district (id,name,id_city) VALUES (141,'Passo da Areia',45);
INSERT INTO district (id,name,id_city) VALUES (142,'Petrópolis',45);
INSERT INTO district (id,name,id_city) VALUES (143,'Rio Branco',45);
INSERT INTO district (id,name,id_city) VALUES (144,'Santana',45);
INSERT INTO district (id,name,id_city) VALUES (145,'Vila Jardim',45);
INSERT INTO district (id,name,id_city) VALUES (146,'São Cristóvão',46);
INSERT INTO district (id,name,id_city) VALUES (147,'São João Bosco',46);
INSERT INTO district (id,name,id_city) VALUES (148,'Aparecida',47);
INSERT INTO district (id,name,id_city) VALUES (149,'Centro',48);
INSERT INTO district (id,name,id_city) VALUES (150,'Bairro da Velha',49);
INSERT INTO district (id,name,id_city) VALUES (151,'Boa Vista',49);
INSERT INTO district (id,name,id_city) VALUES (152,'Centro',49);
INSERT INTO district (id,name,id_city) VALUES (153,'Fortaleza',49);
INSERT INTO district (id,name,id_city) VALUES (154,'Itoupava Central',49);
INSERT INTO district (id,name,id_city) VALUES (155,'Itoupava Norte',49);
INSERT INTO district (id,name,id_city) VALUES (156,'Ponta Aguda',49);
INSERT INTO district (id,name,id_city) VALUES (157,'Salto Weissbach',49);
INSERT INTO district (id,name,id_city) VALUES (158,'Vila Formosa',49);
INSERT INTO district (id,name,id_city) VALUES (159,'Vila Nova',49);
INSERT INTO district (id,name,id_city) VALUES (160,'Belchior Alto',50);
INSERT INTO district (id,name,id_city) VALUES (161,'Atiradores',51);
INSERT INTO district (id,name,id_city) VALUES (162,'Centro',52);
INSERT INTO district (id,name,id_city) VALUES (163,'Centro',53);
INSERT INTO district (id,name,id_city) VALUES (164,'Jardim Bandeirantes',54);
INSERT INTO district (id,name,id_city) VALUES (165,'Alphaville Industrial',55);
INSERT INTO district (id,name,id_city) VALUES (166,'Tamboré',55);
INSERT INTO district (id,name,id_city) VALUES (167,'Arruamento Fain José Feres',56);
INSERT INTO district (id,name,id_city) VALUES (168,'Centro',56);
INSERT INTO district (id,name,id_city) VALUES (169,'Jardim Guanabara',56);
INSERT INTO district (id,name,id_city) VALUES (170,'Jd. Santa',56);
INSERT INTO district (id,name,id_city) VALUES (171,'Vila Brandina',56);
INSERT INTO district (id,name,id_city) VALUES (172,'Parque Jataí',57);
INSERT INTO district (id,name,id_city) VALUES (173,'Vlia Cordeiro',57);
INSERT INTO district (id,name,id_city) VALUES (174,'Pontal de Santa Marina',58);
INSERT INTO district (id,name,id_city) VALUES (175,'Lageadinho',59);
INSERT INTO district (id,name,id_city) VALUES (176,'Porto Da Igreja',60);
INSERT INTO district (id,name,id_city) VALUES (177,'Centro',61);
INSERT INTO district (id,name,id_city) VALUES (178,'Jardim do Mar',62);
INSERT INTO district (id,name,id_city) VALUES (179,'Pinheiros',62);
INSERT INTO district (id,name,id_city) VALUES (180,'Vila Areal',62);
INSERT INTO district (id,name,id_city) VALUES (181,'Itaim',63);
INSERT INTO district (id,name,id_city) VALUES (182,'São Luiz',64);
INSERT INTO district (id,name,id_city) VALUES (183,'Chacara Urbana',65);
INSERT INTO district (id,name,id_city) VALUES (184,'Boituva',66);
INSERT INTO district (id,name,id_city) VALUES (185,'Centro Cívico',66);
INSERT INTO district (id,name,id_city) VALUES (186,'Bela Vista',67);
INSERT INTO district (id,name,id_city) VALUES (187,'Vila Madalena',68);
INSERT INTO district (id,name,id_city) VALUES (188,'São Dimas',69);
INSERT INTO district (id,name,id_city) VALUES (189,'Centro',70);
INSERT INTO district (id,name,id_city) VALUES (190,'Cerqueira César',70);
INSERT INTO district (id,name,id_city) VALUES (191,'Jardim California',70);
INSERT INTO district (id,name,id_city) VALUES (192,'Jardim Irajá',70);
INSERT INTO district (id,name,id_city) VALUES (193,'Matriz',70);
INSERT INTO district (id,name,id_city) VALUES (194,'Vila Do Golf',70);
INSERT INTO district (id,name,id_city) VALUES (195,'Vila Romana',70);
INSERT INTO district (id,name,id_city) VALUES (196,'Alto de Pinheiros',71);
INSERT INTO district (id,name,id_city) VALUES (197,'Jardim Tres Maria',72);
INSERT INTO district (id,name,id_city) VALUES (198,'Parque Faber Castell I',73);
INSERT INTO district (id,name,id_city) VALUES (199,'Centro',74);
INSERT INTO district (id,name,id_city) VALUES (200,'Centro',75);
INSERT INTO district (id,name,id_city) VALUES (201,'Jardim Morumbi',76);
INSERT INTO district (id,name,id_city) VALUES (202,'Jardim Walkíria',76);
INSERT INTO district (id,name,id_city) VALUES (203,'Jardim Oswaldo Cruz',77);
INSERT INTO district (id,name,id_city) VALUES (204,'Alto da Boa Vista',78);
INSERT INTO district (id,name,id_city) VALUES (205,'Alto de Pinheiros',78);
INSERT INTO district (id,name,id_city) VALUES (206,'Bela Vista',78);
INSERT INTO district (id,name,id_city) VALUES (207,'Brooklin',78);
INSERT INTO district (id,name,id_city) VALUES (208,'Brooklin Paulista',78);
INSERT INTO district (id,name,id_city) VALUES (209,'Butantã',78);
INSERT INTO district (id,name,id_city) VALUES (210,'Centro',78);
INSERT INTO district (id,name,id_city) VALUES (211,'Chácara Santo Antonio',78);
INSERT INTO district (id,name,id_city) VALUES (212,'Chácara Santo Antônio',78);
INSERT INTO district (id,name,id_city) VALUES (213,'Cidade Nova',78);
INSERT INTO district (id,name,id_city) VALUES (214,'Cidade Nova II',78);
INSERT INTO district (id,name,id_city) VALUES (215,'Consolação',78);
INSERT INTO district (id,name,id_city) VALUES (216,'Freguesia do Ó',78);
INSERT INTO district (id,name,id_city) VALUES (217,'Imirim',78);
INSERT INTO district (id,name,id_city) VALUES (218,'Indianápolis',78);
INSERT INTO district (id,name,id_city) VALUES (219,'Indianópolis',78);
INSERT INTO district (id,name,id_city) VALUES (220,'Itaim',78);
INSERT INTO district (id,name,id_city) VALUES (221,'Jardim',78);
INSERT INTO district (id,name,id_city) VALUES (222,'Jardim Das Laranjeiras',78);
INSERT INTO district (id,name,id_city) VALUES (223,'Jardim Elizabeth',78);
INSERT INTO district (id,name,id_city) VALUES (224,'Jardim Iris',78);
INSERT INTO district (id,name,id_city) VALUES (225,'Jardim Nova Aliança',78);
INSERT INTO district (id,name,id_city) VALUES (226,'Jardim Paulista',78);
INSERT INTO district (id,name,id_city) VALUES (227,'Jardim São Luiz',78);
INSERT INTO district (id,name,id_city) VALUES (228,'Jardim Sumaré',78);
INSERT INTO district (id,name,id_city) VALUES (229,'Jardim Universidade Pinheiros',78);
INSERT INTO district (id,name,id_city) VALUES (230,'Lapa',78);
INSERT INTO district (id,name,id_city) VALUES (231,'Moema',78);
INSERT INTO district (id,name,id_city) VALUES (232,'Mooca',78);
INSERT INTO district (id,name,id_city) VALUES (233,'Móoca',78);
INSERT INTO district (id,name,id_city) VALUES (234,'Morumbi',78);
INSERT INTO district (id,name,id_city) VALUES (235,'Paraíso',78);
INSERT INTO district (id,name,id_city) VALUES (236,'Penha de Franca',78);
INSERT INTO district (id,name,id_city) VALUES (237,'Perdizes',78);
INSERT INTO district (id,name,id_city) VALUES (238,'Pinheiros',78);
INSERT INTO district (id,name,id_city) VALUES (239,'Santa Cecília',78);
INSERT INTO district (id,name,id_city) VALUES (240,'Santa Cruz do José Jacques',78);
INSERT INTO district (id,name,id_city) VALUES (241,'Santana',78);
INSERT INTO district (id,name,id_city) VALUES (242,'Santo Amaro',78);
INSERT INTO district (id,name,id_city) VALUES (243,'Vila Amelia',78);
INSERT INTO district (id,name,id_city) VALUES (244,'Vila Buarque',78);
INSERT INTO district (id,name,id_city) VALUES (245,'Vila Gertrudes',78);
INSERT INTO district (id,name,id_city) VALUES (246,'Vila Lageado',78);
INSERT INTO district (id,name,id_city) VALUES (247,'Vila Leopoldina',78);
INSERT INTO district (id,name,id_city) VALUES (248,'Vila Madalena',78);
INSERT INTO district (id,name,id_city) VALUES (249,'Vila Mariana',78);
INSERT INTO district (id,name,id_city) VALUES (250,'Vila Medeiros',78);
INSERT INTO district (id,name,id_city) VALUES (251,'Vila Nova',78);
INSERT INTO district (id,name,id_city) VALUES (252,'Vila Nova Conceição',78);
INSERT INTO district (id,name,id_city) VALUES (253,'Vila Olímpia',78);
INSERT INTO district (id,name,id_city) VALUES (254,'Vila Progredior',78);
INSERT INTO district (id,name,id_city) VALUES (255,'Vila Prudente',78);
INSERT INTO district (id,name,id_city) VALUES (256,'Vila Regente Feijó',78);
INSERT INTO district (id,name,id_city) VALUES (257,'Alto de Pinheiros',79);
INSERT INTO district (id,name,id_city) VALUES (258,'Centro',80);
INSERT INTO district (id,name,id_city) VALUES (259,'Jardim Elizabeth',80);
INSERT INTO district (id,name,id_city) VALUES (260,'Vossoroca',80);
INSERT INTO district (id,name,id_city) VALUES (261,'Atalaia',81);
INSERT INTO district (id,name,id_city) VALUES (262,'Catumbi',36);
INSERT INTO district (id,name,id_city) VALUES (263,'Cavaleiros',32);
INSERT INTO district (id,name,id_city) VALUES (264,'Freguesia',36);
INSERT INTO district (id,name,id_city) VALUES (265,'Inhaúma',36);
INSERT INTO district (id,name,id_city) VALUES (266,'Méier',36);
INSERT INTO district (id,name,id_city) VALUES (267,'Pechincha',36);
INSERT INTO district (id,name,id_city) VALUES (268,'Mutuá',37);
INSERT INTO district (id,name,id_city) VALUES (269,'Agriões',38);
INSERT INTO district (id,name,id_city) VALUES (270,'Comercial',82);
INSERT INTO district (id,name,id_city) VALUES (271,'Costa Azul',83);
SELECT setval('district_id_seq', (SELECT MAX(id) FROM district));
");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('phone_user_account');
        $this->dropTable('address_user_account');
        $this->dropTable('address_type');
        $this->dropTable('email_user_account');
        $this->dropTable('email_type');
        $this->dropTable('phone_pin');
        $this->dropTable('phone_type');
        $this->dropTable('pin');
        $this->dropTable('district');
        $this->dropTable('city');
        $this->dropTable('state');
        $this->dropTable('country');
        $this->dropTable('user_account');
    }
}