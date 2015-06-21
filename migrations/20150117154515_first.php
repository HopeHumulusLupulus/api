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

/*
INSERT INTO pin (id_country, id_state, id_city, id_district, name, lat, lng, address, link)
SELECT country.id AS id_country,
       s.id AS id_state,
       c.id AS id_city,
       d.id AS id_district,
       i.nome,
       CAST(TRIM(substring(i.pin from 0 for POSITION(',' in i.pin))) AS float) AS lat,
       CAST(TRIM(substring(i.pin from POSITION(',' in i.pin)+1 for 1000)) AS float) AS lng,
       i.endereco,
       i.link
  FROM importacao i
  JOIN district d ON d.name = i.bairro
  JOIN city c ON c.id = d.id_city AND c.name = TRIM(i.municipio)
  JOIN state s ON s.id = c.id_state
  JOIN country ON country.id = s.id_country
  LEFT JOIN pin ON pin.id_country = country.id
   AND pin.id_state = s.id
   AND pin.id_city = c.id
   AND pin.id_district = d.id
   AND pin.name = i.nome
 WHERE pin.id IS NULL
 ORDER BY d.id, lat;
*/

INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (1,1,1,1,1,'Deck - freshfood&lounge',-9.97562,-67.809105,'Av. Getulio Vargas, 178.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (2,1,1,1,1,'Chico''s Rock Bar',-9.960244,-67.813614,'Rua Alvorada, 327.','http://www.sergibeer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (3,1,2,2,2,'Mr. Beer (Parque Shopping Maceió)',-9.62698,-35.698822,'Av.Comendador Gustavo Paiva , 5945.          ','http://www.mrbeercervejas.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (4,1,2,2,3,'Casa das Cervejas',-9.645182,-35.705105,'Av. Almirante Álvaro Calheiros, 660.','http://www.casadascervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (5,1,3,3,4,'Casebre - Cervejas Especiais',0.0250857,-51.05635,'Av. Diogenes Silva, 58.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (6,1,4,4,5,'Cachaçaria do Dedé & Empório (Shopping Manauara)',-3.104392,-60.01271,'Av. Mário Ypiranga, 1300 -Rest.03 - Piso Buriti','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (7,1,4,4,6,'Cachaçaria do Dedé & Empório (Parque 10)',-3.081,-60.01057,'Rua do Comércio, 1003-F, Box 4.','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (8,1,4,4,7,'Barão Cervejas',-3.066498,-60.01222,'Av. Professor Nilton Lins, 18.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (9,1,4,4,8,'Beers & Beer (Container Mall)',-3.099491,-60.015163,'Rua DRua Thomas, 16.','www.beersbeer.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (10,1,4,4,9,'Frankfurt Bar',-3.073687,-59.998005,'Rua Paul Adam, 344.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (11,1,4,4,9,'Dom Quintas',-3.086883,-60.02411,'Av. Djalma Batista, 2010.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (12,1,4,4,10,'Mr. Beer (Shopping Ponta Negra)',-3.0850375,-60.072475,'Av. Coronel Teixeira, 5.705','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (13,1,4,4,10,'Cachaçaria do Dedé & Empório (Shopping Ponta Negra)',-3.0850375,-60.072475,'Av. Coronel Teixeira, 5.705','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (14,1,4,4,11,'Dois Dois : Loucos por Cerveja',-3.106048,-60.01318,'Av. Mario Ypiranga, 1005, casa 17A.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (15,1,4,4,12,'Biergarten Manaus',-3.0287883,-60.06558,'Av. do Turismo , 5626.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (16,1,5,5,13,'Mr. Beer (Terrazzo Villas)',-12.8833,-38.302704,'Av. Praia de Itapoan, 514.','http://www.mrbeercervejas.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (17,1,5,6,14,'Armazém Beer (Salvador Shopping)',-12.978948,-38.455143,'Av. Tancredo Neves, 3133.','http://www.armazembeerspecial.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (18,1,5,6,15,'Empório Jaguaribe',-12.958179,-38.395493,'Rua da Fauna, 177.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (19,1,5,6,16,'Armazém Beer (Shopping Paralela)',-12.936741,-38.39492,'Av. Luís Viana Filho, 8544. 2 piso.','http://www.armazembeerspecial.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (20,1,5,6,17,'Munik Boteco Gourmet',-12.991461,-38.46082,'Rua Guillard Muniz, 720.','http://www.munikbar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (21,1,5,6,18,'Rhoncus Pub & Beer Store',-13.012812,-38.48733,'Rua Oswaldo Cruz, 122.','http://www.rhoncus.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (22,1,6,7,19,'Sherlocks Pub',-3.735814,-38.506,'Rua Silva Paulet, 1222.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (23,1,7,8,20,'Empório Soares & Souza',-15.872833,-47.916935,'Aeroporto Internacional de Brasília','http://www.emporioss.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (24,1,7,8,21,'Empório Soares & Souza',-15.834543,-48.015717,'Rua 9 Norte, Lote 2 - Loja 4 (Ed. Montebello)','http://www.emporioss.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (25,1,7,8,21,'Boutique do Godofredo',-15.841727,-48.023754,'Av. Araucárias, 1325.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (26,1,7,8,22,'Santuário',-15.744748,-47.88675,'CLN 214, bloco C, Loja 27.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (27,1,7,8,22,'Pinella',-15.760143,-47.880264,'CLN 408, Bloco B, Loja 20.','http://www.pinella.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (28,1,7,8,22,'Empório Soares & Souza',-15.750905,-47.884705,'CLN 212, Bloco B, Loja 3.','http://www.emporioss.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (29,1,7,8,23,'Empório Soares & Souza',-15.809469,-47.885082,'CLS 403, Bloco D, Loja 28.','http://www.emporioss.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (30,1,7,8,24,'Mestre-Cervejeiro.com',-15.797907,-47.920513,'CLSW 301, Bloco C, Sala 158.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (31,1,7,8,25,'Boutique do Godofredo',-15.784032,-47.94804,'CLSW 101, Bloco B, 54','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (32,1,7,8,26,'Stadt Bier',-15.794543,-47.914577,'SIG, Quadra 6, Lote 2190, s/n','www.stadtbier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (33,1,8,9,27,'Taberna Beer',-20.334269,-40.29137,'Rua 15 de Novembro, 1080.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (34,1,8,10,28,'Mr. Beer (Shopping Vitória)',-20.304655,-40.292347,'Av. Américo Buaiz, 200 - Quiosque S118','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (35,1,8,10,29,'WunderBar Kaffee',-20.29493,-40.290283,'Rua Joaquim Lirio, 820.','http://www.wunderbarkaffee.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (36,1,8,10,29,'Mr. Beer',-20.296465,-40.29192,'Rua Joaquim Lírio, 610. Loja 2.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (37,1,8,10,29,'Mestre-Cervejeiro.com',-20.294674,-40.2935,'Av. Rio Branco 1726. Loja 06.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (38,1,9,11,30,'Natur Bier',-16.700163,-49.28499,'Av. C-205, n° 413','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (39,1,9,11,30,'Garagem Pub',-16.705267,-49.291653,'Rua C.118, Q.238 L.17, n° 413 ','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (40,1,9,11,31,'Mr. Beer (Shopping Flamboyant)',-16.710197,-49.236664,'Av. Jamel Cecílio, 3300 ','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (41,1,9,11,32,'Território do Cervejeiro',-16.695896,-49.27799,'Av. T2, 1950','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (42,1,9,11,32,'Rash Bier',-16.69812,-49.27914,'Avenida T. Três, 1390 - Quadra 171, Lote 9','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (43,1,9,11,32,'Prátaí Cult Bar',-16.712337,-49.266994,'Av. T4 Qd 169A Lt 01E n°1478','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (44,1,9,11,32,'Olut',-16.710876,-49.267235,'Avenida T. Quatro, 466','http://www.olut.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (45,1,9,11,33,'Velvet36 Rock’n Roll Bar',-16.695566,-49.26625,'Rua 36, 378','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (46,1,9,11,33,'Pier 13',-16.693544,-49.269897,'Av.Portugal qd.L-23 lt.13 n° 818','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (47,1,9,11,34,'Edelweiss Café',-16.678843,-49.275898,'Rua R2, n° 78','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (48,1,9,11,35,'Glória Bar e Restaurante',-16.685759,-49.259583,'Rua 101, 435 ','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (49,1,9,11,35,'Belgian Dash',-16.680668,-49.24942,'Rua 91, 184','http://www.cervejasespeciais.com.br/site/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (50,1,9,11,36,'Matuto Bar',-16.681921,-49.24524,'Rua 242 n° 190','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (51,1,9,11,37,'Hops Bar',-16.685263,-49.261314,'Rua 10, 181. Galeria 10.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (52,1,10,12,38,'Buteko Lagoa',-2.493137,-44.299095,'Rua dos Maçaricos, 08.','http://www.butekos.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (53,1,11,13,39,'Ray''s American Blend',-15.590855,-56.103985,'Rua Cândido Mariano, 1351.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (54,1,11,13,39,'O''Connell''s Irish Pub',-15.591708,-56.10729,'Av. Isac Póvoas, 1548','http://www.oconnells.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (55,1,11,13,40,'Dom Agostinho Restaurante',-15.603993,-56.096394,'Av. Dom Aquino, 314.','http://dom-agostinho.blogspot.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (56,1,11,13,41,'Empório seleta',-15.586839,-56.11045,'Rua Marechal Floriano Peixoto, 1519.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (57,1,11,13,42,'Empório Serra Grande',-15.594316,-56.105534,'Rua Brigadeiro Eduardo Gomes, 305','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (58,1,11,13,43,'Originale Diparma',-15.589886,-56.106644,'Av. Senador Filinto Müller, 788.','http://www.diparma.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (59,1,11,13,43,'Hookerz',-15.587126,-56.1048,'Av. Senador Filinto Müller, 1398.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (60,1,11,13,43,'Fitz Bottega',-15.591571,-56.10271,'Rua Cândido Mariano, 1100.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (61,1,11,13,44,'Kobe Temakeria e Rolls',-15.594002,-56.10157,'Rua Presidente Marques, 1150.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (62,1,11,14,45,'Mestre-Cervejeiro.com (Rondon Plaza Shopping)',-16.470879,-54.607666,'Av. Lions International, 1950. Quiosque 16.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (63,1,12,15,46,'Casa Do Chef CG',-20.457048,-54.60184,'Rua Euclides da Cunha, 360.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (64,1,12,15,47,'Maracutaia Boteco',-20.463686,-54.602325,'Rua Sete de Setembro, 1971.','http://www.maracutaiaboteco.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (65,1,12,15,48,'Chicken Beer''s',-20.397623,-54.55877,'Av. Cônsul Assaf Trad, 4796.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (66,1,12,15,49,'Morena Bier',-20.475182,-54.724453,'Av. Jamil Nahas, 236.','http://www.morenabier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (67,1,13,16,50,'Reduto da Cerveja',-19.944645,-43.93046,'Rua Pium-í, 570.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (68,1,13,16,51,'Empório Giardino',-19.880465,-44.04159,'Alameda dos Sabiás, 393.','http://www.emporiogiardino.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (69,1,13,16,52,'Empório Veredas',-19.649862,-43.906647,'Rua Alberto Alves de Azevedo, 107.','http://www.emporioveredas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (70,1,13,16,53,'Mamãe Bebidas',-19.92236,-43.93577,'Av. do Contorno, 1955.','http://mamaebebidas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (71,1,13,16,54,'Stadt Jever',-19.939993,-43.931168,'Avenida do Contorno, 5771','https://pt-br.facebook.com/JeverPub');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (72,1,13,16,54,'Café Viena Beer',-19.929123,-43.92189,'Av. do Contorno, 3968.','http://www.cafeviena.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (73,1,13,16,55,'Reduto da Cerveja',-19.929499,-43.944393,'Av. Álvares Cabral, 1030.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (74,1,13,16,56,'Reduto da Cerveja (Shopping Woods)',-19.947428,-43.955204,'Rua Guaicuí, 660.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (75,1,13,16,56,'Artesanato da Cerveja (Shopping Woods)',-19.947428,-43.955204,'Rua Guaicuí, 660.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (76,1,13,16,57,'Rima dos Sabores',-19.927626,-43.96224,'Rua Esmeraldas, 522','http://www.rimadossabores.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (77,1,13,16,58,'BH Cervejas',-19.915289,-43.9553,'Rua Conselheiro Lafaiete, 510. Loja 04.','http://www.bhcervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (78,1,13,16,59,'Nórdico - Chopp Delivery e Cervejas Especiais',-19.842718,-43.974133,'Av. Deputado Anuar Menhem, 35.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (79,1,13,16,60,'Sousplat Restaurante & Sushibar',-19.907536,-43.94214,'Rua Rodrigues Caldas, 186.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (80,1,13,16,61,'Cervejaria Wäls',-19.879683,-43.962513,'Rua Padre Leopoldo Mertens, 1460.','http://www.wals.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (81,1,13,16,62,'Espetinho da Esquina',-19.939163,-43.931896,'Rua Antônio de Albuquerque, 127','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (82,1,13,17,63,'Mr. Beer (Shopping Ipatinga)',-19.496527,-42.56687,'Av. Pedro Linhares Gomes, 3.900','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (83,1,13,18,64,'Bendicto Gole Cervejas Especiais',-22.120026,-45.047787,'Rua Senador Câmara, 144.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (84,1,13,19,65,'Überbräu Bar',-18.919676,-48.280415,'Rua Olegario Maciel 255','http://www.uberbrau.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (85,1,13,19,66,'Cachaçaria do Dedé & Empório (Shopping Uberlândia)',-18.957355,-48.277893,'Av. Paulo Gracindo, 15. Rest. 2.','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (86,1,14,20,67,'Mr. Beer (Belém Boulevard)',-1.4458754,-48.48914,'Av. Visconde de Souza Franco, 776. Loja Q309.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (87,1,15,21,68,'Mr. Beer (Shopping Manaira)',-7.09728,-34.835373,'Av. Governador Flavio Ribeiro Coutinho, 220. Quiosque 35.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (88,1,16,22,69,'Hooligans Pub',-24.95362,-53.469673,'Rua Paraná, 4024.','http://www.hooliganspub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (89,1,16,23,70,'Mestre-Cervejeiro.com',-24.951612,-53.472454,'Rua Marechal Floriano, 3278.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (90,1,16,24,71,'Cervejaria Asgard',-25.449682,-49.272827,'Rua Brigadeiro Franco, 3388','www.asgardcervejaria.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (91,1,16,24,72,'Cervejaria da Vila',-25.404236,-49.271233,'Rua Mateus Leme, 2631.','http://cervejariadavila.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (92,1,16,24,73,'Hop''n Roll',-25.419075,-49.270973,'Rua Mateus Leme, 950.','http://www.hopnroll.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (93,1,16,24,74,'Mestre-Cervejeiro.com',-25.43772,-49.3241,'Rua Deputado Heitor Alencar Furtado, 1623.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (94,1,16,24,75,'Quintal do Monge',-25.427652,-49.272224,'Rua Doutor Claudino dos Santos, 24.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (95,1,16,25,76,'Mestre-Cervejeiro.com',-25.396849,-51.4731,'Rua Guaíra, 2688.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (96,1,16,26,77,'Mestre-Cervejeiro.com',-23.329456,-51.17437,'Rua João Wyclif, 500.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (97,1,16,27,78,'Pintxos Maringá Cervejas Artesanais',-23.420427,-51.928387,'Av. Pedro Tanques, 91.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (98,1,16,28,79,'Mestre-Cervejeiro.com',-25.089819,-50.162098,'Av. Doutor Francisco Burzio, 805. Loja 01.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (99,1,17,29,80,'UK Pub',-8.114876,-34.896343,'Rua Francisco da Cunha, 165.','http://www.ukpub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (100,1,17,29,81,'Snaubar Esfiharia e Cervejaria',-8.03223,-34.914368,'Rua Doutor Virgílio Mota, 48.','http://www.snaubar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (101,1,17,29,81,'Capitão Taberna',-8.035824,-34.908962,'Rua João Tude de Melo, 77. Loja 27.','http://www.casadascervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (102,1,18,30,82,'Bierbrau Cervejas Especiais',-5.063171,-42.784252,'Av. Homero Castelo Branco, 2420.','http://www.bierbrau.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (103,1,19,31,83,'Noi Bar & Restaurante',-22.755669,-41.886845,'Rua Manoel Turíbio de Farias, 110.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (104,1,19,32,84,'Ocean Drive Empório',-22.304272,-41.696957,'Av. Atlântica, 2720. Loja 04 e 05.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (105,1,19,33,85,'Bergut Vinho & Bistrô',-22.900023,-43.112617,'Rua Miguel de Frias nº 169','http://www.bergut.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (106,1,19,33,85,'Fina Cerva',-22.90515,-43.101387,'Av. Sete de Setembro, 193. Loja 103.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (107,1,19,33,85,'Empório Icaraí Delicatessen',-22.902027,-43.109997,'Rua Mem de Sá, 111 - Loja 1','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (108,1,19,33,86,'Bocca Choperia',-22.747469,-42.862003,'Av. 22 de maio, 5243.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (109,1,19,33,87,'Cervejaria e Restaurante Noi',-22.944195,-43.036217,'Est. Francisco da Cruz Nunes, 1964.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (110,1,19,33,88,'Bar & Bistrô Noi',-22.90315,-43.105213,'Rua Ministro Otávio Kelly, 174. Loja 109.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (111,1,19,33,89,'Armazém e Botequim Granel',-22.896894,-43.09956,'Rua Vereador Duque Estrada, 50','www.armazemgranel.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (112,1,19,33,90,'Porto Di Vino',-22.919249,-43.087246,'Av. Rui Barbosa, 274 Lojas 101 a 103','https://portodivino.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (113,1,19,33,90,'Restaurante Noi',-22.91732,-43.094463,'Av. Quintino Bocaiúva, 159','http://www.cervejarianoi.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (114,1,19,33,90,'La Bière Pub',-22.918097,-43.094467,'Av. Quintino Bocaiúva, 325. Loja 117.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (115,1,19,34,91,'Coliseu Cervejas',-22.512241,-43.17846,'Rua Gen. Osório, 76','www.coliseucervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (116,1,19,34,91,'Cervejaria e Restaurante Bohemia',-22.50693,-43.184982,'Rua Alfredo Pachá, 166','http://www.cervejariabohemia.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (117,1,19,34,92,'CerveJota Bar e Botequim',-22.293531,-43.116814,'Estrada União e Indústria, 11811','http://www.cervejota.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (118,1,19,34,93,'Cervejaria Cidade Imperial',-22.497028,-43.200035,'Rua Mosela, 1.341 (Módulo 01)','http://www.cidadeimperial.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (119,1,19,35,94,'Mr. Beer',-22.459572,-44.43695,'Rua Dorival Marcondes Godoy, 500. Loja 1003.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (120,1,19,36,95,'Botequim do Itahy',-22.943016,-43.340878,'Estrada de Jacarepaguá, 7544.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (121,1,19,36,96,'Armazém Therezópolis (Shopping Downtown)',-23.003832,-43.317997,'Avenida das Américas, 500 - Bl. 9 - Loja 105','armazemtherezopolis.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (122,1,19,36,96,'Nook Bier',-22.973595,-43.36446,'Avenida Embaixador Abelardo Bueno, 01 – Loja 170','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (123,1,19,36,96,'Roshbier (Shopping Downtown)',-23.003832,-43.317997,'Avenida das Américas, 500 - Bl. 22, Sl. 111','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (124,1,19,36,96,'Bar do Elias',-23.013441,-43.305218,'Rua Olegário Maciel, 162','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (125,1,19,36,96,'Nook Bier',-22.973904,-43.364876,'Av. Embaixador Abelardo Bueno, 1. Loja 170.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (126,1,19,36,96,'Mr. Beer (Shopping Metropolitano)',-22.971987,-43.373337,'Av. Embaixador Abelardo Bueno, 1300.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (127,1,19,36,96,'Mr. Beer (Barra Square Shopping Center)',-23.001225,-43.347576,'Av. Marechal Henrique Lott, 333. Bloco 02. Loja 101.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (128,1,19,36,96,'Beertaste Respect Styles - Shopping Città America',-23.003107,-43.32183,'Av. das Américas, 700. Bloco B. Loja 117-E.','http://www.beertaste.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (129,1,19,36,96,'Beertaste Respect Styles - Casa Shopping',-22.992807,-43.364143,'Av. Ayrton Senna, 2150. Bloco N. Loja I.','http://www.beertaste.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (130,1,19,36,96,'Barbearia Tradicional Navalha de Ouro - Rosa Shopping',-23.002213,-43.34956,'Av. Marechal Henrique Lott, 120. Loja 132.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (131,1,19,36,97,'Dream Beer - CADEG',-22.894735,-43.236633,'Rua  Capitão Félix, 110. Rua 13. Loja 5.','http://www.dreambeer.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (132,1,19,36,98,'The Boua Kitchen Bar',-22.949629,-43.184868,'Rua Nelson Mandela, 100','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (133,1,19,36,98,'Cafofo Pub',-22.949896,-43.184963,'Rua Nelson Mandela, 106','cafofopub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (134,1,19,36,98,'Boteco Salvação',-22.955324,-43.19195,'Rua Henrique de Novais, 55','botecosalvacao.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (135,1,19,36,98,'Bon Vivant',-22.950876,-43.182915,'Rua Voluntários da Patria, 46','www.bonvivant.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (136,1,19,36,98,'Lupulino',-22.95147,-43.18268,'Rua Professor Álvaro Rodrigues, 148. Loja A.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (137,1,19,36,98,'Inverso Bar',-22.954248,-43.18654,'Rua Mena Barreto, 22.','http://www.inversobar.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (138,1,19,36,98,'Espaço Caverna',-22.956568,-43.184685,'Rua Assis Bueno, 26','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (139,1,19,36,98,'Empório Farinha Pura',-22.954895,-43.197193,'Rua Voluntários da Pátria, 446.','http://www.farinhapura.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (140,1,19,36,98,'Degustare Delicatessen',-22.949554,-43.188854,'Rua Guilhermina Guinle, 296. Loja B.','http://www.degustareiguarias.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (141,1,19,36,98,'Comuna',-22.951605,-43.189972,'Rua Sorocaba, 585.','http://www.comuna.cc');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (142,1,19,36,98,'Boteco Colarinho',-22.94931,-43.18425,'Rua Nelson Mandela, 100. Loja 127.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (143,1,19,36,98,'Bar Teto Solar',-22.956171,-43.18617,'Rua Paulo Barreto, 110A.','http://www.bartetosolar.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (144,1,19,36,99,'Mr. Beer (Norte Shopping)',-22.887257,-43.28169,'Av. Dom Hélder Câmara, 5200. Quiosque 12A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (145,1,19,36,99,'Cervejaria Suingue (Norte Shopping)',-22.886065,-43.283264,'Av. Dom Hélder Câmara, 5474. Piso S. Loja 4506.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (146,1,19,36,100,'Bergut Vinho & Bistrô',-22.904451,-43.172913,'Av. Erasmo Braga nº 299','http://www.bergut.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (147,1,19,36,101,'Empório Colonial',-22.90455,-43.173084,'Rua Erasmo Braga, 278 - Lojas C e D','https://pt-br.facebook.com/emporiocolonial');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (148,1,19,36,101,'Bergut Vinho & Bistrô',-22.909195,-43.177982,'Rua Senador Dantas nº 100','http://www.bergut.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (149,1,19,36,101,'Veniche Vinhos & Tal',-22.911047,-43.18553,'Av. Henrique Valadares, 17. Stand 4.','http://www.venichevinhosetal.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (150,1,19,36,101,'Taberna Bier',-22.90514,-43.174828,'Rua São José, 35, Loja 231','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (151,1,19,36,101,'Tabaco Café',-22.906887,-43.17765,'Av. Rio Branco, 156. Loja 121.','http://www.tabacocafe.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (152,1,19,36,101,'Monte Gordo',-22.910915,-43.177082,'Rua Senador Dantas, 44.','www.montegordo.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (153,1,19,36,101,'La Sagrada Familia',-22.902775,-43.17792,'Rua do Rosário, 98. Sobreloja.','http://www.lasagradafamilia.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (154,1,19,36,101,'Jacques & Costa Barbearia e Chopp',-22.908627,-43.177505,'Av. Treze de Maio, 33. Loja 407.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (155,1,19,36,101,'Il Piccolo Caffè',-22.903425,-43.17606,'Rua do Carmo, 50','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (156,1,19,36,101,'Dufry Shopping',-22.904928,-43.176037,'Rua da Assembléia, 51.','http://www.dufryshopping.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (157,1,19,36,101,'Botequim do Itahy',-22.907143,-43.1776,'Av. Rio Branco, 156.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (158,1,19,36,101,'Botequim do Itahy',-22.908764,-43.17468,'Rua Araújo Porto Alegre, 56.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (159,1,19,36,101,'Bistrô CD Centro',-22.905285,-43.175957,'Rua da Quitanda, 3. Loja B.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (160,1,19,36,101,'Beer Underground',-22.907034,-43.177174,'Av. Rio Branco, 156. Subsolo. Loja 101.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (161,1,19,36,101,'Al Farabi',-22.901665,-43.17558,'Rua do Rosário, 30.','http://www.alfarabi.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (162,1,19,36,101,'Adega do Pimenta',-22.907124,-43.182022,'Praça Tiradentes, 6.','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (163,1,19,36,102,'Dom Barcelos',-22.911768,-43.202003,'Rua Correia Vasques, 39.','http://dombarcelos.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (164,1,19,36,103,'The Clover Irish Pub',-22.975866,-43.188126,'Av. Atlântica, 3056','https://pt-br.facebook.com/TheClover.RJ');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (165,1,19,36,103,'Pub Escondido, CA',-22.978537,-43.1898,'Rua Aires Saldanha, 98 A','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (166,1,19,36,103,'Os Imortais Bar e Restaurante',-22.964487,-43.177055,'Rua Ronald de Carvalho, 147.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (167,1,19,36,103,'Doca´s Beer',-22.963566,-43.17656,'Rua Belfort Roxo, 231. Loja A.','http://docasbeer.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (168,1,19,36,103,'Brasserie Brejauvas',-22.976297,-43.189217,'Rua Aires de Saldanha, 13.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (169,1,19,36,104,'Assis Garrafaria',-22.939291,-43.196125,'Rua Cosme Velho, 174.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (170,1,19,36,105,'Mr. Beer (Shopping Nova América)',-22.848871,-43.32142,'Av. Pastor Martin Luther King Jr, 126. Anexo Novo. Quiosque QT16.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (171,1,19,36,106,'Sublime',-22.934492,-43.175404,'Rua Senador Vergueiro, 45. Loja 1.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (172,1,19,36,106,'Herr Brauer',-22.933079,-43.17556,'Rua Barão do Flamengo, 35.','http://www.herrbrauer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (173,1,19,36,107,'Porto Di Vino',-22.974648,-43.22702,'Praça Santos Dumont, 140 Loja A','https://portodivino.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (174,1,19,36,108,'Antiga Mercearia e Bar',-22.955091,-43.196735,'Rua Voluntários da Pátria, 446. Loja 7.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (175,1,19,36,109,'Belgian Beer Paradise',-22.984362,-43.19953,'Rua Visconde de Pirajá, 219','www.beerparadise.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (176,1,19,36,109,'The Ale House',-22.98369,-43.212273,'Rua Visconde de Pirajá, 580','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (177,1,19,36,109,'Shenanigan''s Irish Pub',-22.98446,-43.198395,'Rua Visconde de Pirajá, 112A.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (178,1,19,36,109,'La Carioca Cevicheria',-22.982111,-43.209335,'Rua Garcia D''ávila, 173. Loja A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (179,1,19,36,109,'Delirium Café',-22.983507,-43.20134,'Rua Barão da Torre, 183.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (180,1,19,36,109,'Botequim do Itahy',-22.983013,-43.206963,'Rua Maria Quitéria, 74. Loja A.','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (181,1,19,36,109,'Botequim do Itahy',-22.983093,-43.205036,'Rua Barão da Torre, 334.','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (182,1,19,36,109,'Bier en Cultuur',-22.983719,-43.207108,'Rua Maria Quitéria, 77.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (183,1,19,36,110,'Mr. Beer (Shopping Via Parque)',-22.982561,-43.364296,'Av. Ayrton Senna, 3000. Quiosque 55.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (184,1,19,36,111,'Casa Carandaí',-22.964794,-43.22016,'Rua Lopes Quintas, 165','http://casacarandai.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (185,1,19,36,111,'La Carioca Cevicheria',-22.961832,-43.207783,'Rua Maria Angélica, 113A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (186,1,19,36,111,'Gibeer',-22.964693,-43.220047,'Rua Lopes Quintas, 158.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (187,1,19,36,112,'Lapa Irish Pub',-22.913673,-43.179996,'Rua Evaristo da Veiga, 147','www.chefsclub.com.br/lapa-irish-pub‎');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (188,1,19,36,112,'Multifoco Bistrô',-22.912663,-43.183983,'Av. Mem de Sá, 126.','http://www.multifocobistro.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (189,1,19,36,112,'Il Piccolo Caffè Biergarten',-22.912071,-43.184677,'Rua dos Inválidos, 135.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (190,1,19,36,112,'Espaço Lapa Café',-22.910784,-43.18364,'Rua Gomes Freire, 457.','http://www.espacolapacafe.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (191,1,19,36,112,'Boteco Carioquinha',-22.913933,-43.182663,'Av. Gomes Freire, 822. Loja A.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (192,1,19,36,112,'Bar do Ernesto',-22.914997,-43.177937,'Largo da Lapa, 41.','http://www.barernesto.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (193,1,19,36,113,'Boteco D.O.C.',-22.938524,-43.193104,'Rua das Laranjeiras, 486.','http://www.botecodoc.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (194,1,19,36,114,'Biergarten',-22.930307,-43.177658,'Largo do Machado, 29. Loja 202.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (195,1,19,36,115,'Jeffrey Store',-22.979122,-43.22379,'Rua Tubira, 8.','http://www.jeffrey.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (196,1,19,36,115,'Herr Pfeffer',-22.980854,-43.22264,'Rua Conde Bernadotte, 26. Loja D.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (197,1,19,36,115,'Brewteco',-22.982948,-43.22567,'Rua Dias Ferreira, 420.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (198,1,19,36,115,'Botequim do Itahy',-22.985195,-43.22605,'Av Ataulfo de Paiva, 1060. ','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (199,1,19,36,116,'Botequim Rio Antigo',-22.84661,-43.267673,'Rua Uranos, 1489. ','http://www.botequimrioantigo.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (200,1,19,36,117,'CervejáRio',-22.886633,-43.28926,'Av. Dom Helder Câmara, 6001. Loja F. (BRSTORES)','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (201,1,19,36,118,'The Hellish Pub',-22.913073,-43.21445,'Rua Barão de Iguatemi 292','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (202,1,19,36,118,'Tempero da Praça',-22.913692,-43.215378,'Rua Barão de Iguatemi, 408','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (203,1,19,36,118,'Leonique Distribuidora Bebidas e Gelo',-22.922056,-43.233063,'Rua Teixeira Soares, 117.','http://www.leonique.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (204,1,19,36,118,'Botto Bar',-22.912807,-43.213852,'Rua Barão de Iguatemi, 205','http://www.bottobar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (205,1,19,36,118,'Bar da Frente',-22.91346,-43.215214,'Rua Barão de Iguatemi, 388','www.bardafrente.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (206,1,19,36,118,'Aconchego Carioca',-22.913532,-43.21516,'Rua Barão de Iguatemi, 379','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (207,1,19,36,119,'CineBotequim',-22.898731,-43.178722,'Rua Conselheiro Saraiva, 39','http://www.cinebotequim.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (208,1,19,36,120,'Acervo Cervejas Especiais',-23.012568,-43.455982,'Av. Guilherme de Almeida, 83','https://www.facebook.com/AcervoCervejasEspeciais');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (209,1,19,36,120,'Mr. Beer (Shopping Rio Design Barra)',-23.001425,-43.385902,'Av. Das Américas, 7777. Loja 332A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (210,1,19,36,120,'Mr. Beer (Américas Shopping)',-23.012585,-43.462177,'Av. Das Américas, 15500. Quiosque 5.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (211,1,19,36,120,'Itahy Premium Beer',-23.011477,-43.443108,'Av. Alfredo Balthazar da Silveira 520 Loja 101.','http://www.botequimdoitahyrj.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (212,1,19,36,121,'Cafecito',-22.921331,-43.18643,'Rua Paschoal Carlos Magno, 121.','http://www.cafecito.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (213,1,19,36,121,'Adega do Pimenta',-22.92066,-43.184814,'Rua Almirante Alexandrino, 296','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (214,1,19,36,122,'Bar do Omar',-22.903101,-43.20423,'Rua Sara, 114. Loja 1.','https://pt-br.facebook.com/BarDoOmar');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (215,1,19,36,122,'Balkonn Distribuidora',-22.944561,-43.287685,'Rua Pedro Alves, 240.','http://www.balkonnsab.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (216,1,19,36,123,'Beer e Bier Cafe',-22.919523,-43.400494,'Estrada do Rio Grande, 3486.','www.beerebier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (217,1,19,36,124,'Delix - Prix',-22.935238,-43.243763,'Rua Conde De Bonfim, 812','www.superprix.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (218,1,19,36,124,'Otto Bar e Restaurante',-22.932365,-43.241447,'Rua Uruguai, 380','www.otto.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (219,1,19,36,124,'Anossa Cervejaria',-22.929272,-43.243603,'Rua Engenheiro Ernani Cotrim, 15 - Loja B','https://www.facebook.com/anossacervejaria');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (220,1,19,36,124,'Yeasteria',-22.918674,-43.23931,'Rua Pereira Nunes, 266','http://yeasteria.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (221,1,19,36,124,'Mr. Beer (Shopping Tijuca)',-22.914803,-43.22872,'Av. Maracanã, 987. Quiosque 205.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (222,1,19,36,124,'Malte & Cia',-22.925846,-43.24491,'Rua Barão de Mesquita, 663. Loja 19.','https://www.malteecia.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (223,1,19,36,124,'Lupulus',-22.923635,-43.229538,'Rua Conde de Bonfim, 255. Q5.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (224,1,19,36,124,'Hopfen Cervejas Especiais',-22.913084,-43.227158,'Av. Maracanã, 727 - Loja H.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (225,1,19,36,124,'Gato Cervejeiro',-22.923796,-43.235905,'Rua Barão de Mesquita, 356. Loja B.','http://gatocervejeiro.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (226,1,19,36,124,'Delicatessen Nygri',-22.93217,-43.241264,'Rua. Uruguai, 380.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (227,1,19,36,124,'Delicatessen Carioca',-22.929195,-43.243263,'Rua  Uruguai, 280.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (228,1,19,36,124,'Confeitaria Rita de Cássia',-22.922718,-43.22222,'Rua Conde de Bonfim, 28.','http://www.confeitariaritadecassia.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (229,1,19,36,124,'Cerveja Social Clube',-22.919855,-43.231094,'Rua Barão de Mesquita, 141. Loja C.','http://www.cervejasocialclube.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (230,1,19,36,124,'Bobinot - Café e Bistrô',-22.931519,-43.238655,'Rua Conde de Bonfim, 615. Loja A.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (231,1,19,36,124,'Bento',-22.918598,-43.23587,'Rua Almirante João Cândido Brasil, 134. Loja A','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (232,1,19,36,124,'Benditho Bar',-22.922293,-43.237503,'Rua Baltazar Lisboa, 47. ','http://www.bendithobar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (233,1,19,36,124,'Bar Rio Brasília',-22.918915,-43.213844,'Rua Almirante Gavião, 11.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (234,1,19,36,125,'Confraria Cervejas Especiais',-22.890364,-43.28573,'Rua  DRua Ferrari, 115.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (235,1,19,37,126,'Rodobier',-22.824438,-43.04929,'Rua Salvatori, 15, Lj. 3','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (236,1,19,38,127,'Vila St. Gallen',-22.435759,-42.976345,'Rua Augusto do Amaral Peixoto, 166.','http://www.vilastgallen.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (237,1,19,38,128,'Cenário Bier',-22.412367,-42.964733,'Rua Prefeito Sebastião Teixeira, 20. Loja 203.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (238,1,19,39,129,'Bier Prosit Cervejas Especiais',-22.501114,-44.092907,'Av. Lucas Evangelista de Oliveira Franco, 1036.','http://www.bierprosit.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (239,1,20,40,130,'Estação do Malte',-5.881486,-35.17524,'Rua Poeta Jorge Fernandes, 146.','http://www.estacaodomalte.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (240,1,21,41,131,'Empório Canela',-29.363968,-50.81038,'Rua Felisberto Soares, 258.','http://www.emporiocanela.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (241,1,21,42,132,'Pub Garagem 23',-29.59146,-51.160336,'Av. Presidente Lucena, 3510.','http://www.pubgaragem23.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (242,1,21,43,133,'Cervejaria Edelbrau',-29.364569,-51.091553,'Av. 15 de Novembro, 4024','www.edelbrau.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (243,1,21,44,134,'Pubis Bar',-29.674637,-51.11153,'Avenida Doutor Maurício Cardoso, 112.','http://pubis.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (244,1,21,44,134,'Barburguer - The best burguer and beer',-29.684996,-51.11944,'Rua Gomes Portinho, 822.','http://www.barburguer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (245,1,21,45,135,'MaltStore',-30.03867,-51.1911,'Rua Amélia Teles, 396','maltstore.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (246,1,21,45,136,'Lagom Brewery & Pub',-30.034492,-51.208797,'Rua Bento Figueiredo, 72.','http://lagom.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (247,1,21,45,137,'Mestre-Cervejeiro.com (Shopping Rua da Praia)',-30.030622,-51.231377,'Rua dos Andradas, 1001. Loja 133.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (248,1,21,45,137,'Infiel - Bar de cervejas especiais',-30.039213,-51.219852,'Rua General Lima e Silva, 776. Loja 4.','http://www.infiel.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (249,1,21,45,137,'Armazém Porto Alegre',-30.033094,-51.22775,'Av. Borges de Medeiros, 786.','http://armazemportoalegre.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (250,1,21,45,138,'Malvadeza Pub',-30.038462,-51.225826,'Travessa do Carmo, 76.','http://www.malvadeza.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (251,1,21,45,138,'Apolinário Bar',-30.039808,-51.22357,'Rua José do Patrocínio, 527.','http://www.apolinariobar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (252,1,21,45,139,'Mercado Brasco',-30.027836,-51.202976,'Rua Doutor Florêncio Ygartua, 151','www.mercadobrasco.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (253,1,21,45,139,'MaltStore',-30.024406,-51.202522,'Rua Padre Chagas, 339','maltstore.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (254,1,21,45,139,'Le Grand Burger',-30.020317,-51.20248,'Rua Marquês do Pombal, 191','legrandburger.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (255,1,21,45,139,'Lagom Brewery & Pub',-30.026108,-51.20112,'Rua Comendador Caminha, 312.','http://lagom.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (256,1,21,45,139,'Cervejomaniacos Pub e Armazém do Cervejeiro',-30.02255,-51.199448,'Rua Tobias da Silva, 229.','http://www.cervejomaniacos.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (257,1,21,45,139,'Bier Markt Vom Fass',-30.021023,-51.203606,'Rua Barão de Santo Ângelo, 497.','http://www.biermarkt.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (258,1,21,45,139,'Bier Markt Shop',-30.026392,-51.203007,'Rua 24 de Outubro, 513, loja 1.','http://www.biermarkt.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (259,1,21,45,140,'The Public Market',-30.027746,-51.185497,'Rua Pedro Chaves Barcelos, 651','https://pt-br.facebook.com/thepublicmarketstore');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (260,1,21,45,141,'Restaurante DaDo Bier (Bourbon Shopping Country)',-30.02241,-51.16287,'Av. Túlio de Rose, 80. 2ºAndar.','http://www.dadobier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (261,1,21,45,142,'Bier Keller',-30.040907,-51.183643,'Rua João Abott, 596','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (262,1,21,45,143,'Bier Markt',-30.03061,-51.20633,'Rua Castro Alves, 442.','http://www.biermarkt.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (263,1,21,45,144,'Cuca Haus',-30.0524,-51.201378,'Rua São Luis, 1101.','http://www.cucahaus.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (264,1,21,45,145,'Boteco Mafioso',-30.035555,-51.151558,'Av. Saturnino de Brito, 738.','http://botecomafioso.blogspot.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (265,1,22,46,146,'Novo boteco',-8.758595,-63.90068,'Av. Pinheiro Machado, 1356.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (266,1,22,46,147,'Out Beer Special',-8.750431,-63.89442,'Rua João Goulart, 3002.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (267,1,23,47,148,'O Cajueiro',2.83584,-60.660065,'Rua João Pereira Caldas, 54.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (268,1,24,48,149,'Mestre-Cervejeiro.com',-26.976593,-48.637127,'Av. Brasil, 146. Loja 4.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (269,1,24,48,149,'Das Bier Litoral',-26.999393,-48.630486,'Rua 2950, 426.','http://www.dasbier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (270,1,24,49,150,'Estação Vila Bar (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (271,1,24,49,150,'Choperia Alemão Batata (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (272,1,24,49,150,'Bier Vila Choperia (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199','http://www.biervila.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (273,1,24,49,151,'Butiquin Wollstein',-22.851334,-43.096573,'Rua Marechal Floriano Peixoto, 89','http://www.butiquinwollstein.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (274,1,24,49,152,'The Basement English Pub',-26.920713,-49.064857,'Rua Paul Hering, 35','http://www.basementpub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (275,1,24,49,153,'Cervejaria Wunder Bier',-26.8919,-49.063328,'Rua Fritz Spernau, 155','http://wunderbier.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (276,1,24,49,154,'Container British Beer',-26.8101,-49.0874,'Rua Gustavo Zimmermann, 4764','www.cervejariacontainer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (277,1,24,49,154,'Cervejaria Bierland',-26.804913,-49.087883,'Rua Gustavo Zimmermann, 5361','http://www.bierland.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (278,1,24,49,155,'Das Bier Kneipe',-26.886635,-49.068558,'Via Expressa Paul Fritz Kuehnrich, 1600 (Shopping Park Europeu).','http://www.dasbier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (279,1,24,49,156,'SpitzBier Bar & Choperia',-27.108402,-52.616516,'Rua Uruguai, 111 - Sala 07','http://www.spitzbier.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (280,1,24,49,157,'Estação Eisenbahn',-26.893234,-49.126385,'Rua Bahia, 5181','http://www.eisenbahn.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (281,1,24,49,158,'Café Alameda',-26.923052,-49.060585,'Alameda Rio Branco, 63','https://pt-br.facebook.com/cafealamedagourmet');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (282,1,24,49,159,'Don Pub',-26.911427,-49.085876,'Rua Alm. Tamandaré, 1220','https://pt-br.facebook.com/donpubbnu');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (283,1,24,50,160,'Das Bier Choperia',-26.821537,-49.023155,'Rua Bonifácio Haendchen, 5311','http://www.dasbier.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (284,1,24,51,161,'Biergarten Chopp & Cozinha',-26.309322,-48.85461,'Rua Visconde de Taunay, 1183.','http://www.biergarten.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (285,1,24,52,162,'Cervejaria Schornstein Kneipe - Bar da Fábrica',-26.712324,-49.164288,'Rua Hermann Weege, 60','www.schornstein.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (286,1,24,53,163,'Restaurante e Pizzaria Edelweiss',-26.999765,-51.41479,'Rua DRua Gaspar Coutinho, 439.','http://www.bierbaum.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (287,1,25,54,164,'Mr. Beer',-21.788025,-48.217247,'Av. Alberto Benassi, 2270. Quiosque Ponto D.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (288,1,25,55,165,'Mr. Beer (Iguatemi Alphaville)',-23.50466,-46.84772,'Alameda Rio Negro, 111. Quiosque 305.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (289,1,25,55,165,'Mr. Beer (Alpha Shopping)',-23.497797,-46.84871,'Alameda Rio Negro, 1033.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (290,1,25,55,166,'Mr. Beer',-23.5043,-46.8325,'Av. Piracema, 669. Quiosque E20.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (291,1,25,56,167,'Andanças Bar',-22.822945,-47.083157,'Rua Agostinho Pattaro, 124','andancasbar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (292,1,25,56,168,'Casa Amarela Rock Bar',-23.531155,-46.816204,'Rua DRua Mariano Jatahy Marcondes Ferraz, 96','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (293,1,25,56,169,'Mr. Beer',-22.88129,-47.05534,'Av. Barão De Itapura, 2935.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (294,1,25,56,170,'Mr. Beer (Parque Dom Pedro)',-22.848867,-47.063873,'Av. Guilherme Campos, 500. Loja 430.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (295,1,25,56,171,'Mr. Beer (Iguatemi Campinas)',-22.892569,-47.02751,'Av. Iguatemi, 777. Quisoque Q106.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (296,1,25,57,172,'Cervejaria Bamberg',-23.568874,-47.459465,'Rua Sebastião Benedito Reis, 582','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (297,1,25,57,173,'Empório Bierboxx',-23.616869,-46.693527,'Rua Miguel Sutil, 358','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (298,1,25,58,174,'Mestre-Cervejeiro.com',-23.667933,-45.436535,'Av. José Herculano, 1086. Quiosque 05.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (299,1,25,59,175,'Mr. Beer (The Square Granja Vianna)',-23.589981,-46.824497,'Rodovia Raposo Tavares, Km 22. Praça das Árvores, 12.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (300,1,25,59,175,'Mr. Beer (Shopping Granja Vianna)',-23.591724,-46.833847,'Rodovia Raposo Tavares, Km 23. Piso L1.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (301,1,25,60,176,'Mr. Beer (Shopping Guarulhos)',-22.818678,-43.319645,'Rodovia Presidente Dutra, Km 230. Quiosque 35.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (302,1,25,61,177,'Cervejaria Schornstein Krug - Bar da Fábrica',-22.63262,-47.037975,'Rua Rota dos Imigrantes, 2301','www.schornstein.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (303,1,25,62,178,'Einbier Cervejas Especiais',-23.688124,-46.56302,'Rua Antártico, 328-C','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (304,1,25,62,179,'Delirium Café',-23.562908,-46.697975,'Rua Ferreira de Araújo, 589','http://www.deliriumcafesp.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (305,1,25,62,180,'Mestre-Cervejeiro.com',-23.081049,-47.20818,'Av. Presidente Kennedy, 625.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (306,1,25,63,181,'Vino!',-23.583355,-46.674244,'Rua Professor Tamandaré de Toledo, 51.','www.lojavino.com.br/lojas/sp');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (307,1,25,64,182,'Mr. Beer (Plaza Itu)',-23.263985,-47.280422,'Av. Doutor Ermelindo Maffei, 1199. Quiosque A8.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (308,1,25,65,183,'Mr. Beer',-23.189285,-46.891678,'Av. Nove De Julho, 1155. Loja 206.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (309,1,25,66,184,'Velharia Pub Bar',-23.28652,-47.67246,'Rua Angelo Ribeiro, 274.','http://www.velhariapub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (310,1,25,66,185,'Mr. Beer (Mogi Shopping)',-23.516851,-46.178978,'Av. Vereador Narciso Yague Guimarães, 1001. Loja QE02','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (311,1,25,67,186,'Titus Bar',-23.559551,-46.64971,'Rua Rocha, 370.','http://www.titusbar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (312,1,25,68,187,'Villa Grano',-23.556479,-46.691647,'Rua Wizard, 500.','www.villagrano.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (313,1,25,69,188,'Mestre-Cervejeiro.com',-22.711868,-47.64581,'Travessa Doná Eugênia, 402. Loja 01.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (314,1,25,70,189,'Especial Beer',-23.524836,-46.189262,'Rua 1º de Setembro, 247, Piso Superior','http://www.especialbeer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (315,1,25,70,190,'Casa da Cerveja',-23.559858,-46.67946,'Rua Lisboa, 502','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (316,1,25,70,191,'Mr. Beer (Ribeirão Shopping)',-22.91008,-43.177193,'Av. Coronel Fernando Ferreira Leite, 1540. Quiosque 147.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (317,1,25,70,192,'Mr. Beer',-21.20616,-47.806946,'Rua Do Professor, 499. Sala 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (318,1,25,70,193,'Don Corleone Bar e Petiscaria',-23.67286,-46.460133,'Av. Dom José Gaspar, 458','http://doncorleonebar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (319,1,25,70,194,'Mr. Beer (Iguatemi Ribeirao Preto)',-21.226177,-47.834774,'Av. Luiz Eduardo Toledo Prado, 900. Loja 1062.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (320,1,25,70,195,'Cerveja Gourmet',-23.527987,-46.695393,'Rua Tito 400','http://cervejagourmet.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (321,1,25,71,196,'Melograno',-23.557507,-46.6897,'Rua Aspicuelta, 436','www.melograno.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (322,1,25,72,197,'Mr. Beer (Golden Square)',-23.684095,-46.558376,'Av. Kennedy, 700. Loja 186.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (323,1,25,73,198,'Mr. Beer (Iguatemi São Carlos)',-22.01744,-47.915813,'Passeio Dos Flamboyants, 200. Quiosque 102.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (324,1,25,74,199,'Mr. Beer',-21.97629,-46.798244,'Rua Santo Antonio, 32.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (325,1,25,75,200,'Kingsford Pub',-23.496601,-47.465298,'Av. DRua Afonso Vergueiro, 1479','https://www.facebook.com/kingsfordpub');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (326,1,25,76,201,'Mr. Beer (Riopreto Shopping)',-20.835062,-49.39854,'Av Brigadeiro Faria Lima, 6363. Loja 198.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (380,1,25,78,244,'The Joy',-23.54593,-46.65131,'Rua Maria Antônia, 330.','http://www.thejoy.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (327,1,25,76,202,'Mr. Beer (Plaza Avenida Shopping)',-20.827705,-49.388004,'Av. José Munia, 4775. Loja 176A.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (328,1,25,77,203,'Mr. Beer (Center Vale)',-23.200306,-45.880802,'Av. Deputado Benedito Matarazzo, 9403. Quiosque QV 06.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (329,1,25,78,204,'Cervejarium',-21.20246,-47.819183,'Av. Independência, 3.242','www.coloradocervejarium.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (330,1,25,78,205,'Empório Sagarana',-23.556772,-46.688087,'Rua Aspicuelta, 271','www.emporiosagarana.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (331,1,25,78,206,'Mr. Beer (Top Center)',-23.56595,-46.65064,'Av. Paulista, 854. Q13.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (332,1,25,78,206,'Mr. Beer (Shopping Center 3)',-23.55876,-46.65939,'Av. Paulista, 2064. Quiosque 4.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (333,1,25,78,207,'Tortula',-23.621655,-46.683903,'Av. Santo Amaro, 4.371.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (334,1,25,78,208,'Mr. Beer (Shopping D&D)',-23.60862,-46.697124,'Av. Das Nações Unidas, 12551. Loja 108A.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (335,1,25,78,209,'Cervejaria Ô Fiô',-23.585918,-46.718243,'Rua Lício Marcondes do Amaral, 51','cervejariaofio.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (336,1,25,78,210,'Nosso Bar',-22.905716,-47.057983,'Rua Barão de Jaguara, 988, Box 02.','http://nossobarcervejasespeciais.blogspot.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (337,1,25,78,210,'Butréco Butiquim',-20.80123,-49.385937,'Rua Pedro Amaral, 1822','https://www.facebook.com/butreco.butiquim');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (338,1,25,78,210,'BRB-Blues Rock Beer',-24.320168,-47.00489,'Avenida 24 de Dezembro, 45','https://www.facebook.com/pages/BRB-Blues-Rock-Beer/306320206070196');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (339,1,25,78,210,'Bar Brejas',-22.902262,-47.051723,'Rua Conceição, 860','barbrejas.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (340,1,25,78,211,'Laus Beer Loja',-23.634203,-46.698795,'Rua Fernandes Moreira, 384','www.santebar.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (341,1,25,78,212,'Mr. Beer',-23.63345,-46.70532,'Rua Verbo Divino, 986. Quiosque 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (342,1,25,78,213,'Mundo Beer',-23.08578,-47.207096,'Avenida Itororó, 681.','https://www.facebook.com/mundobeerindaiatuba');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (343,1,25,78,214,'Bendito Malte',-23.076614,-47.201168,'Av. Conceição, 1950','https://www.facebook.com/benditomalte');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (344,1,25,78,215,'Cervejaria Devassa - Bela Cintra',-23.559643,-46.665268,'Rua Bela Cintra, 1.579','http://www.cervejariadevassa.com.br/index.php/unidades/bela-cintra');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (345,1,25,78,216,'FrangÓ',-23.50113,-46.69858,'Lg. da Matriz da N. S. do Ó, 168','frangobar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (346,1,25,78,217,'Leão da Terra',-23.487091,-46.643192,'Av. Engenheiro Caetano Álvares, 4666','http://www.leaodaterra.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (347,1,25,78,218,'Belgian Beer Paradise',-23.60487,-46.666813,'Av. Ibijaú, 196','www.beerparadise.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (348,1,25,78,219,'Mr. Beer',-23.61098,-46.66924,'Av. Ibirapuera, 3103. Quiosque 50.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (349,1,25,78,220,'Coisa Boa',-23.582058,-46.679195,'Rua Pedroso Alvarenga, 909','https://www.facebook.com/coisaboabar');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (350,1,25,78,221,'Asgard Pub',-23.654701,-46.53594,'Rua das Bandeiras, 421','http://www.asgardpub.com/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (351,1,25,78,222,'Mr. Beer',-23.509266,-46.661686,'Rua Relíquia, 383. Quiosque 1.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (352,1,25,78,223,'Fräulein Bierhaus',-22.718636,-45.565983,'Rua Isola Orsi, 33','http://www.fraulein.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (353,1,25,78,224,'Mr. Beer (Plaza Tiete)',-23.506273,-46.717285,'Av. Raimundo Pereira De Magalhães, 1465. Quiosque 105.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (354,1,25,78,225,'Empório Biergarten',-21.215042,-47.823734,'Av. Lygia Latuf Salomão, 605, Mercadão da Cidade - Box 83','www.emporiobiergarten.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (355,1,25,78,226,'Karavelle Brew Pub',-23.562187,-46.667713,'Alameda Lorena, 1784','http://www.karavelle.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (356,1,25,78,226,'Asterix',-23.56673,-46.651382,'Alameda Joaquim Eugênio de Lima, 575','www.barasterix.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (357,1,25,78,226,'All Black Irish Pub',-23.56768,-46.663925,'Rua Oscar Freire, 163','http://allblack.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (358,1,25,78,226,'Aconchego Carioca',-23.560913,-46.660667,'Alameda Jaú, 1.372','http://www.facebook.com/aconchegocariocasp');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (359,1,25,78,227,'Mr. Beer',-23.648783,-46.73095,'Av. Maria Coelho Águiar, 215.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (360,1,25,78,228,'Bar Vila Dionísio Ribeirão Preto',-21.18738,-47.811146,'Rua Eliseu Guilherme, 567','http://www.viladionisio.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (361,1,25,78,229,'Mr. Beer',-23.591919,-46.691715,'Av. Das Nações Unidas, 4777.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (362,1,25,78,230,'Bezerra',-23.52592,-46.69301,'Rua Coriolano, 800','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (363,1,25,78,231,'Bier Bär',-23.59948,-46.66807,'Rua Tuim, 253','http://www.bierbar.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (364,1,25,78,232,'A Boa Cerveja',-23.557463,-46.595947,'Rua Capitães Mores, 414','http://www.aboacerveja.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (365,1,25,78,233,'1ª Cervejaria da Móoca',-23.56254,-46.593426,'Rua Guaimbê, 148','www.primeiracervejariadamooca.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (366,1,25,78,234,'Market Place - Laus Beer Quiosque',-23.621418,-46.69904,'Av. DRua Chucri Zaidan, 902','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (367,1,25,78,235,'Adega Tutóia',-23.574245,-46.651962,'Rua Tutóia, 260.','http://www.adegatutoia.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (368,1,25,78,236,'Armazém 77',-23.529026,-46.545315,'Rua Betari, 520','https://www.facebook.com/armazem77');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (369,1,25,78,237,'Mestre-Cervejeiro.com',-23.536154,-46.681114,'Rua Vanderlei, 1595.','www.mestre-cervejeiro.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (370,1,25,78,238,'Mr. Beer',-23.562468,-46.67521,'Av. Rebouças, 3970. Quiosque Q56.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (371,1,25,78,238,'BrewDog Bar',-23.56137,-46.693886,'Rua dos Coropés, 41','https://www.facebook.com/brewdogsaopaulo/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (372,1,25,78,238,'Beer Legends - Bar e Cervejaria',-23.558302,-46.691246,'Rua Mourato Coelho, 1112','http://www.beerlegends.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (373,1,25,78,238,'Bar Cervejaria Nacional',-23.56475,-46.690678,'Avenida Pedroso de Morais, 604','http://www.cervejarianacional.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (374,1,25,78,238,'Arturito',-23.559944,-46.67758,'Rua Artur de Azevedo, 542','www.arturito.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (375,1,25,78,239,'Rota do Acarajé',-23.541315,-46.654236,'Rua Martim Francisco, 529.','www.rotadoacaraje.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (376,1,25,78,240,'Spader Bar',-21.200386,-47.800735,'Rua Humaita, 80.','https://www.facebook.com/spaderbar');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (377,1,25,78,241,'Empório Laura Aguiar',-23.502054,-46.62067,'Rua Gabriel Piza, 559','http://emporiolauraaguiar.blogspot.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (378,1,25,78,242,'Tchê Café',-23.63084,-46.668568,'Av. Washington Luis, 5628.','http://www.tchecafe.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (379,1,25,78,243,'Cervejaria Invicta',-21.17494,-47.830826,'Avenida do Café, 1365','https://www.facebook.com/CervejariaInvictaBar');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (381,1,25,78,245,'Mr. Beer (Market Place)',-23.593897,-46.692265,'Av. Das Nações Unidas, 13947. Quiosque 104.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (382,1,25,78,246,'Pay Per Beer',-23.556675,-46.75523,'Rua Professor Herbert Baldus, 125.','http://www.payperbeer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (383,1,25,78,247,'Mr. Beer',-23.524837,-46.733208,'Rua Carlos Weber, 382. Loja 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (384,1,25,78,248,'BierBoxx',-23.559673,-46.68895,'Rua Fradique Coutinho,842','http://barbierboxx.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (385,1,25,78,249,'Pier 1327',-23.587671,-46.64509,'Rua Joaquim Távora, 1327.','http://www.pier1327.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (386,1,25,78,249,'Let''s Beer',-23.586386,-46.641716,'Rua Joaquim Távora, 961.','http://www.letsbeer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (387,1,25,78,249,'Beer Bamboo',-23.58632,-46.641132,'Rua Joaquim Távora, 895.','http://www.beerbamboo.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (388,1,25,78,250,'Mocotó',-23.48669,-46.581673,'Av. Nossa Senhora do Loreto, 1.100','www.mocoto.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (389,1,25,78,251,'Confrades Bier Shop',-23.275764,-47.29078,'Av. Prudente de Moraes, 210','http://cervejariaconfrades.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (390,1,25,78,252,'Mr. Beer',-23.591228,-46.67678,'Rua Doutor Alceu de Campos Rodrigues, 476.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (391,1,25,78,252,'Kia Ora Pub',-23.588879,-46.6754,'Rua Doutor Eduardo de Souza Aranha, 377','www.kiaora.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (392,1,25,78,253,'Rock Fella Burgers & Beers',-23.59373,-46.68475,'Rua Rócio, 89.','http://www.facebook.com/RockFellaBurgersBeers');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (393,1,25,78,254,'Mr. Beer',-23.594715,-46.72052,'Av. Jorge João Saad, 900. Sobreloja 6.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (394,1,25,78,255,'Mr. Beer (Mooca Plaza Shopping)',-23.579807,-46.594517,'Rua Capitão Pacheco e Chaves, 313. Quadra 11. Loja 2.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (395,1,25,78,256,'Mr. Beer',-23.553097,-46.563496,'Rua Emília Marengo, 383.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (396,1,25,79,257,'Empório Alto dos Pinheiros',-23.559996,-46.69952,'Rua Vupabussu, 305','www.eapsp.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (397,1,25,80,258,'The Square Pub',-23.985214,-48.879295,'Rua Teófilo David Muzel, 100','http://www.thesquarepub.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (398,1,25,80,259,'Cervejaria Baden Baden',-22.718983,-45.567295,'Rua DRua Djalma Forjaz, 93','www.obadenbaden.com.br');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (399,1,25,80,260,'Mr. Beer (Iguatemi Sorocaba)',-22.951702,-43.37692,'Av. Gisele Constantino, 1800. Loja 124B.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (400,1,26,81,261,'Calles Bar de Tapas',-10.990155,-37.049873,'Avenida Santos Dumont, 188.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (401,1,19,36,101,'enchendo linguica',-22.912409,-43.184734,'Rua dos Inválidos, 164a - Centro, Rio de Janeiro - RJ, 20231-045, Brasil',null);
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (402,1,19,36,262,'teste11',-22.920137,-43.19575,'Rua Doutor Agra, 66 - Catumbi, Rio de Janeiro - RJ, Brasil','seila');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (403,1,6,7,19,'Tupinibeer Cervejas Especiais',-3.736024,-38.50369,'Rua Nunes Valente, 1247.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (404,1,19,33,85,'Armazém São Jorge',-22.90458,-43.101948,'Rua Dr. Leandro Mota, 8. Loja B.','http://www.armazemsaojorge.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (405,1,19,34,92,'Vagão Beer and Food (Shopping Estação Itaipava)',-22.395615,-43.133057,'Estrada União e Indústria, 11.000.','http://vagaobeer.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (406,1,19,36,121,'Aprazível Restaurante',-22.924812,-43.187485,'Rua Aprazível, 62.','http://www.aprazivel.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (407,1,19,36,121,'Rústico',-22.921284,-43.18644,'Rua Paschoal Carlos Magno, 121.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (408,1,19,36,124,'Gullos Tabacaria',-22.932232,-43.241283,'Rua Uruguai, 380.','http://www.gullotabacaria.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (409,1,19,36,124,'Bar do Momo',-22.9298,-43.24312,'Rua General Espírito Santo Cardoso, 50. Loja A.','https://www.facebook.com/bardomomotijuca');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (410,1,19,36,124,'Mistura e Manda',-22.919926,-43.233852,'Rua Major Ávila, 455.','https://pt-br.facebook.com/MisturaManda');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (411,1,19,36,124,'Itajubar',-22.915203,-43.216972,'Rua Vicente Licínio, 57','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (412,1,19,36,124,'Gran Delli',-22.903135,-43.244328,'Rua São Francisco Xavier, 352.','http://grandellicatessen.blogspot.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (413,1,19,38,128,'Taberna Alpina',-22.411514,-42.96861,'Rua Duque de Caxias, 131.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (414,1,19,38,128,'Vagão Beer and Food',-22.409664,-42.96733,'Av. Lúcio Meira, 855.','http://vagaobeer.com');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (415,1,25,78,232,'1ª Cervejaria da Móoca',-23.56254,-46.593426,'Rua Guaimbê, 148','www.primeiracervejariadamooca.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (416,1,19,32,263,'Kebab Store (Macaé Palace)',-22.40017,-41.792267,'Av. Atlântica, 1788. Loja 08.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (417,1,19,36,264,'Revolution Pub',-22.939354,-43.336918,'Rua Comandante Rubens Silva, 448.','http://revolutionrio.blogspot.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (418,1,19,36,264,'Bravado Carnes Nobres',-22.93799,-43.33733,'Rua Comandante Rubens Silva, 292. Loja 107. ','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (419,1,19,36,264,'Armazém Urbano',-22.931103,-43.332344,'Estrada do Páu-Ferro, 1070','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (420,1,19,36,265,'Bistrô Estação R&R',-22.866898,-43.27301,'Travessa Jalisco, 32.','http://www.bistroestacaorer.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (421,1,19,36,266,'Wenceslau Beer Club',-22.900492,-43.28085,'Rua Silva Rabêlo, 61.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (422,1,19,36,267,'Deliciando Quitanda Gourmet',-22.926357,-43.34704,'Estrada do Pau Ferro, 313.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (423,1,19,37,268,'The Souzas',-22.814482,-43.03969,'Av. Paula Lemos, 17.','https://www.facebook.com/pages/The-Souzas-Cervejas-e-Gourmet');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (424,1,19,38,269,'Cenário Bier',-22.420303,-42.976513,'Rua Carmela Dutra, 306.','');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (425,1,19,82,270,'Casa do Fritz',-22.43879,-44.525234,'Av. das Mangueiras, 518.','http://www.casadofritz.com.br/');
INSERT INTO pin (id,id_country,id_state,id_city,id_district,name,lat,lng,address,link) VALUES (426,1,19,83,271,'Brewpub Elixir',-22.517878,-41.94791,'Av. Roberto Silveira 319.','https://www.facebook.com/brewpubelixir');

SELECT setval('pin_id_seq', (SELECT MAX(id) FROM pin));

UPDATE pin SET enabled = created WHERE enabled IS NULL;
UPDATE pin SET enabled_by = 'vitor.mattos@gmail.com' WHERE enabled_by IS NULL;
UPDATE pin SET created_by = 'vitor.mattos@gmail.com' WHERE enabled_by IS NULL;

INSERT INTO phone_type (type) VALUES ('Empresarial');
INSERT INTO phone_type (type) VALUES ('Celular');
INSERT INTO phone_type (type) VALUES ('Outros');

INSERT INTO email_type (type) VALUES ('Empresarial');
INSERT INTO email_type (type) VALUES ('Particular');
INSERT INTO email_type (type) VALUES ('Outros');

/*
INSERT INTO phone_pin(number, id_phone_type, id_pin)
SELECT x.number,
       CASE WHEN CAST(SUBSTRING(x.number, 3, 1) AS int) = 9
              OR (
                      LENGTH(x.number) = 11
                  AND CAST(SUBSTRING(x.number, 1, 1) AS int) <> 0
                 ) THEN 2
            ELSE 1
        END AS id_phone_type,
       x.id
  FROM (
         SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(i.telefone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', '') AS number,
                p.id
           FROM importacao i
           JOIN pin p ON p.name = i.nome AND p.address = i.endereco
           WHERE length(i.telefone) > 0
       ) AS x
  LEFT JOIN phone_pin pp ON pp.id_pin = x.id
 WHERE pp.id IS NULL
*/

INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6833016224',1,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6832236627',2,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'8291518116',3,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8230336028',4,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9681217883',5,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9232366642',6,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9232360025',7,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9233024613',8,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9236320350',10,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9233436880',11,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9233460777',12,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9236677303',13,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9232325471',15,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7135084721',16,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7141112636',17,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7133673536',18,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7141035406',19,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7134522746',20,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7130194344',21,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8230336028',22,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6133649443',23,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'6130849306‎',24,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6135675527',25,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6130395667',26,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6133478334',27,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'6139637022‎',28,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6135326702',29,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6130216667',30,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6130216500',31,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6133446777',32,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2732291643',33,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2733256711',34,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2732274331',35,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2733171446',36,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2733158908',37,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6232857541',38,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239240459',39,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239549760',40,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239327497',41,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6230864928',42,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239321454',43,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239201316',44,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239418549',45,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239261313',46,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6238777954',47,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6232249033',48,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6232186792',49,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6239411708',50,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6236365082',51,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9832680044',52,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530239008',53,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6536242748',54,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530528450',55,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530543616',56,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6541413876',57,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530230287',58,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530525387',59,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6530540997',60,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6521270583',61,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6630225011',62,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6732010999',63,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'6792326911',64,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6781990890',65,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6733637958',66,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3133177974',67,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3133969584',68,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3132438824',69,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3132139494',70,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3132235056',71,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3132219555',72,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125151770',73,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125119680',74,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125310660',75,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3132437120',76,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125101377',77,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125730239',78,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3125164181',79,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3134432811',80,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'3199541088',81,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3186519495',82,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3533314806',83,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3432322672',84,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'3432256200',85,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9181187565',86,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8321066401',87,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4530390072',88,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4530372690',89,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4133330001',90,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4130154620',91,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4134084486',92,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4130726921',93,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4132325679',94,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4230361377',95,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4333452015',96,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4488060825',97,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4230273087',98,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8134669192',99,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8132045104',100,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8132048668',101,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8632332430',102,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2227571336',104,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126207666',105,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2127146348',106,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126107175',107,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126353554',108,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2127093939',109,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2137412945',110,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2136299629',111,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126102360',112,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126110619',113,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2127107390',114,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2422316619',115,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125129919',116,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2422223252',117,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2422204800',118,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'24998137323',119,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2124560705',120,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2134337827',121,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132815339',122,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2134195597',123,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2134354977',124,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132815339',125,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2130959239',126,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21995103815',127,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2130837420',132,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2134960865',133,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122269691',134,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125372857',135,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2137963435',137,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132398000',139,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125276909',140,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2130290789',141,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21995416922',144,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122201887',146,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131784094',147,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125327332',148,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122210514',149,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2141096301',150,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122202156',151,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122522240',153,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'08007238379',156,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122620190',157,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122401017',158,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125245338',159,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125333861',160,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122330879',161,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125488484',164,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125229800',165,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135638959',166,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131178082',167,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125488964',168,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122053598',169,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135460945',170,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2137380466',171,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2121374154',173,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122266553',174,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132562595',175,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122675860',177,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122473356',180,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125222919',181,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21979625442',183,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131140179',184,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122217236',187,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122223034',188,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125096455',192,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122740000',195,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122591999',198,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2138676124',199,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135471999',200,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131733008',203,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2134967407',204,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125020176',205,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2121484265',208,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21995103815',209,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21995103815',210,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125183881',214,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2140636210',215,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135972219',216,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125709747',217,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122681579',218,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131732560',219,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135793003',220,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122010446',221,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132385832',222,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2132282720',223,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2131971278',225,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122686896',226,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2125713497',227,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122641517',228,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2122101378',229,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2121430077',230,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2137969809',232,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2135983170',233,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2126421575',236,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'21988838283',237,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'2433467612',238,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'8433463919',239,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5430311000',240,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5182238223',241,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5432814555',242,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'5191021010',243,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130655661',244,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5132793133',245,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130625045',246,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130611002',247,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130724800',248,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5132260308',249,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5132217833',250,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130130158',251,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5135738333',252,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130617500',253,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5133951520',254,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130266660',255,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5131088616',256,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5135740927',257,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5132082300',258,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130855111',259,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5133783000',260,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130842360',261,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5130132300',262,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5132173826',263,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'5135192555',264,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6930434001',265,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'6932241855',266,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'9536235377',267,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733440125',268,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733633030',269,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733292121',270,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733294242',271,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733290808',272,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'4799824292',273,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733400534',274,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733390001',275,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4732857185',276,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733373100',277,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733977519',278,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4734885040',279,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4734887371',280,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733356011',281,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4730371518',282,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733978600',283,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4734233790',284,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4733876655',285,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'4935370531',286,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1632142024',287,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1141950235',288,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11982250346',289,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11982250346',290,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1933681125',291,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136854500',292,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1932912117',293,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11968501274',294,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1932534604',295,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1238859676',298,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11953136727',299,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1147023344',300,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1124141268',301,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1938021391',302,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1143174008',303,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1124952225',304,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1933941377',305,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130786442',306,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1127150599',307,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11996887535',308,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'15998347201',309,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1147254503',310,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1133845595',311,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138132725',312,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1934321728',313,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1143128902',314,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1636212389',316,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1633292753',317,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1134201966',318,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1639132995',319,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136750761',320,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130312921',321,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1178991141',322,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1634197005',323,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'19997006085',324,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1533461064',325,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1733046691',326,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136280691',380,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1730339820',327,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1239132455',328,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1639114949',329,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130310816',330,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11948706483',331,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11987753665',332,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130439082',334,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1137216636',335,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1932339498',336,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1732343141',337,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'13997042330',338,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1932517912',339,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135670569',340,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135696162',341,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1933295735',342,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130816081',344,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1139324818',345,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136249056',346,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135967150',347,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1150933978',348,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130730773',349,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1149026035',350,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135895805',351,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1236631529',352,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1122356382',353,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1632370722',354,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1133685610',356,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130887990',357,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130628262',358,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1137418222',359,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1636107416',360,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11963966727',361,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138624646',362,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1150516695',363,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1126150512',364,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1126045275',365,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138844343',367,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135646899',368,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138713911',369,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1121977907',370,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130324007',371,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1129259422',372,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136285000',373,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130634951',374,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1136686222',375,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1631015410',376,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1129770471',377,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1150317537',378,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1638781020',379,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1151818569',381,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135424730',382,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1123092694',383,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138050151',384,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1155396213',385,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1125899695',386,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1138951565',387,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1129513056',388,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (2,'11967741215',389,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1143242618',390,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130453597',391,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1125375380',393,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1135484645',394,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1125335676',395,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1130314328',396,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1535224150',397,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1236636082',398,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'1532475943',399,null);
INSERT INTO phone_pin (id_phone_type,number,id_pin,other_type) VALUES (1,'7930252725',400,null);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('8530162020',1,403);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('21983664822',2,404);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2422320015',1,405);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2125089174',1,406);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2134973579',1,407);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2134952723',1,408);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2125878756',1,410);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2125657893',1,411);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2135292349',1,412);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2127420123',1,413);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2126433034',1,414);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('1126045275',1,415);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2227657316',1,416);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2135925001',1,417);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2131773447',1,418);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2124255522',1,419);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2138848388',1,420);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2131746614',1,421);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2127135381',1,423);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('21988838283',2,424);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2433511751',1,425);
INSERT INTO phone_pin (number,id_phone_type,id) VALUES ('2233230303',1,426);

SELECT setval('phone_pin_id_seq', (SELECT MAX(id) FROM phone_pin));
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