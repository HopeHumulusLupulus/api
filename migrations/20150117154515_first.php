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
            ->addForeignKey('id_district', $district, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin->save();

        $phone_type = $this->table('phone_type')
            ->addColumn('type', 'string', array('limit' => 15));
        $phone_type->save();

        $phone = $this->table('phone')
            ->addColumn('id_phone_type', 'integer')
            ->addColumn('number', 'string', array('limit' => 15))
            ->addColumn('entity', 'string', array('limit' => 40))
            ->addColumn('id_entity', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_phone_type', $phone_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $phone->save();

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
INSERT INTO city (id,name,id_state) VALUES (37,'Teresópolis',19);
INSERT INTO city (id,name,id_state) VALUES (38,'Volta Redonda',19);
INSERT INTO city (id,name,id_state) VALUES (39,'Natal',20);
INSERT INTO city (id,name,id_state) VALUES (40,'Canela',21);
INSERT INTO city (id,name,id_state) VALUES (41,'Ivoti',21);
INSERT INTO city (id,name,id_state) VALUES (42,'Novo Hamburgo',21);
INSERT INTO city (id,name,id_state) VALUES (43,'Porto Alegre',21);
INSERT INTO city (id,name,id_state) VALUES (44,'Porto Velho',22);
INSERT INTO city (id,name,id_state) VALUES (45,'Boa Vista',23);
INSERT INTO city (id,name,id_state) VALUES (46,'Balneário Camboriú',24);
INSERT INTO city (id,name,id_state) VALUES (47,'Balneário de Camboriú',24);
INSERT INTO city (id,name,id_state) VALUES (48,'Blumenau',24);
INSERT INTO city (id,name,id_state) VALUES (49,'Gaspar',24);
INSERT INTO city (id,name,id_state) VALUES (50,'Treze Tílias',24);
INSERT INTO city (id,name,id_state) VALUES (51,'Araraquara',25);
INSERT INTO city (id,name,id_state) VALUES (52,'Barueri',25);
INSERT INTO city (id,name,id_state) VALUES (53,'Campinas',25);
INSERT INTO city (id,name,id_state) VALUES (54,'Campos do Jordão',25);
INSERT INTO city (id,name,id_state) VALUES (55,'Caraguatatuba',25);
INSERT INTO city (id,name,id_state) VALUES (56,'Cotia',25);
INSERT INTO city (id,name,id_state) VALUES (57,'Guarulhos',25);
INSERT INTO city (id,name,id_state) VALUES (58,'Indaiatuba',25);
INSERT INTO city (id,name,id_state) VALUES (59,'Itapeva',25);
INSERT INTO city (id,name,id_state) VALUES (60,'Itu',25);
INSERT INTO city (id,name,id_state) VALUES (61,'Jundiaí',25);
INSERT INTO city (id,name,id_state) VALUES (62,'Mogi Das Cruzes',25);
INSERT INTO city (id,name,id_state) VALUES (63,'Osasco',25);
INSERT INTO city (id,name,id_state) VALUES (64,'Peruíbe',25);
INSERT INTO city (id,name,id_state) VALUES (65,'Piracicaba',25);
INSERT INTO city (id,name,id_state) VALUES (66,'Ribeirão Preto',25);
INSERT INTO city (id,name,id_state) VALUES (67,'Santo André',25);
INSERT INTO city (id,name,id_state) VALUES (68,'São Bernardo Do Campo',25);
INSERT INTO city (id,name,id_state) VALUES (69,'São Carlos',25);
INSERT INTO city (id,name,id_state) VALUES (70,'São João Da Boa Vista',25);
INSERT INTO city (id,name,id_state) VALUES (71,'São José do Rio Preto',25);
INSERT INTO city (id,name,id_state) VALUES (72,'São José Do Rio Preto',25);
INSERT INTO city (id,name,id_state) VALUES (73,'São José Dos Campos',25);
INSERT INTO city (id,name,id_state) VALUES (74,'São Paulo',25);
INSERT INTO city (id,name,id_state) VALUES (75,'Sorocaba',25);
INSERT INTO city (id,name,id_state) VALUES (76,'Votorantim',25);
INSERT INTO city (id,name,id_state) VALUES (77,'Aracajú',26);

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
INSERT INTO district (id,name,id_city) VALUES (26,'Centro',9);
INSERT INTO district (id,name,id_city) VALUES (27,'Enseada do Suá',10);
INSERT INTO district (id,name,id_city) VALUES (28,'Praia do Canto',10);
INSERT INTO district (id,name,id_city) VALUES (29,'Jardim América',11);
INSERT INTO district (id,name,id_city) VALUES (30,'Jardim Goiás',11);
INSERT INTO district (id,name,id_city) VALUES (31,'Setor Bueno',11);
INSERT INTO district (id,name,id_city) VALUES (32,'Setor Marista',11);
INSERT INTO district (id,name,id_city) VALUES (33,'Setor Oeste',11);
INSERT INTO district (id,name,id_city) VALUES (34,'Setor Sul',11);
INSERT INTO district (id,name,id_city) VALUES (35,'Setor Universitário',11);
INSERT INTO district (id,name,id_city) VALUES (36,'Vila São Francisco',11);
INSERT INTO district (id,name,id_city) VALUES (37,'Ponta do Farol',12);
INSERT INTO district (id,name,id_city) VALUES (38,'Centro Norte',13);
INSERT INTO district (id,name,id_city) VALUES (39,'Dom Aquino',13);
INSERT INTO district (id,name,id_city) VALUES (40,'Duque de Caxias',13);
INSERT INTO district (id,name,id_city) VALUES (41,'Popular',13);
INSERT INTO district (id,name,id_city) VALUES (42,'Quilombo',13);
INSERT INTO district (id,name,id_city) VALUES (43,'Santa Helena',13);
INSERT INTO district (id,name,id_city) VALUES (44,'Sagrada Família',14);
INSERT INTO district (id,name,id_city) VALUES (45,'Centro',15);
INSERT INTO district (id,name,id_city) VALUES (46,'Jardim Aclimação',15);
INSERT INTO district (id,name,id_city) VALUES (47,'Novos Estados',15);
INSERT INTO district (id,name,id_city) VALUES (48,'Núcleo Industrial',15);
INSERT INTO district (id,name,id_city) VALUES (49,'Anchieta',16);
INSERT INTO district (id,name,id_city) VALUES (50,'Cabral',16);
INSERT INTO district (id,name,id_city) VALUES (51,'Castelo',16);
INSERT INTO district (id,name,id_city) VALUES (52,'Floresta',16);
INSERT INTO district (id,name,id_city) VALUES (53,'Funcionários',16);
INSERT INTO district (id,name,id_city) VALUES (54,'Lourdes',16);
INSERT INTO district (id,name,id_city) VALUES (55,'Luxemburgo',16);
INSERT INTO district (id,name,id_city) VALUES (56,'Prado',16);
INSERT INTO district (id,name,id_city) VALUES (57,'Sagrada Família',16);
INSERT INTO district (id,name,id_city) VALUES (58,'Santa Amelia',16);
INSERT INTO district (id,name,id_city) VALUES (59,'Santo Agostinho',16);
INSERT INTO district (id,name,id_city) VALUES (60,'São Francisco',16);
INSERT INTO district (id,name,id_city) VALUES (61,'Savassi',16);
INSERT INTO district (id,name,id_city) VALUES (62,'Horto',17);
INSERT INTO district (id,name,id_city) VALUES (63,'Centro',18);
INSERT INTO district (id,name,id_city) VALUES (64,'Morada da Colina',19);
INSERT INTO district (id,name,id_city) VALUES (65,'Nazaré',20);
INSERT INTO district (id,name,id_city) VALUES (66,'Loteamento Parque Verde',21);
INSERT INTO district (id,name,id_city) VALUES (67,'Centro',22);
INSERT INTO district (id,name,id_city) VALUES (68,'Centro',23);
INSERT INTO district (id,name,id_city) VALUES (69,'Bom Retiro',24);
INSERT INTO district (id,name,id_city) VALUES (70,'Centro Cívico',24);
INSERT INTO district (id,name,id_city) VALUES (71,'Mossunguê',24);
INSERT INTO district (id,name,id_city) VALUES (72,'São Francisco',24);
INSERT INTO district (id,name,id_city) VALUES (73,'Alto da XV',25);
INSERT INTO district (id,name,id_city) VALUES (74,'Gleba Palhano',26);
INSERT INTO district (id,name,id_city) VALUES (75,'Zona 01',27);
INSERT INTO district (id,name,id_city) VALUES (76,'Centro',28);
INSERT INTO district (id,name,id_city) VALUES (77,'Boa Viagem',29);
INSERT INTO district (id,name,id_city) VALUES (78,'Paranamirim',29);
INSERT INTO district (id,name,id_city) VALUES (79,'Ininga',30);
INSERT INTO district (id,name,id_city) VALUES (80,'Lot. Triângulo de Búzios',31);
INSERT INTO district (id,name,id_city) VALUES (81,'Lagomar',32);
INSERT INTO district (id,name,id_city) VALUES (82,'Icaraí',33);
INSERT INTO district (id,name,id_city) VALUES (83,'Itaboraí',33);
INSERT INTO district (id,name,id_city) VALUES (84,'Itaipu',33);
INSERT INTO district (id,name,id_city) VALUES (85,'Jardim Icaraí',33);
INSERT INTO district (id,name,id_city) VALUES (86,'São Francisco',33);
INSERT INTO district (id,name,id_city) VALUES (87,'Centro',34);
INSERT INTO district (id,name,id_city) VALUES (88,'Mosela',34);
INSERT INTO district (id,name,id_city) VALUES (89,'Paraíso',35);
INSERT INTO district (id,name,id_city) VALUES (90,'Anil',36);
INSERT INTO district (id,name,id_city) VALUES (91,'Barra da Tijuca',36);
INSERT INTO district (id,name,id_city) VALUES (92,'Benfica',36);
INSERT INTO district (id,name,id_city) VALUES (93,'Botafogo',36);
INSERT INTO district (id,name,id_city) VALUES (94,'Cachambi',36);
INSERT INTO district (id,name,id_city) VALUES (95,'Centro',36);
INSERT INTO district (id,name,id_city) VALUES (96,'Cidade Nova',36);
INSERT INTO district (id,name,id_city) VALUES (97,'Copacabana',36);
INSERT INTO district (id,name,id_city) VALUES (98,'Cosme Velho',36);
INSERT INTO district (id,name,id_city) VALUES (99,'Del Castilho',36);
INSERT INTO district (id,name,id_city) VALUES (100,'Flamengo',36);
INSERT INTO district (id,name,id_city) VALUES (101,'Humaitá',36);
INSERT INTO district (id,name,id_city) VALUES (102,'Ipanema',36);
INSERT INTO district (id,name,id_city) VALUES (103,'Jacarepaguá',36);
INSERT INTO district (id,name,id_city) VALUES (104,'Jardim Botânico',36);
INSERT INTO district (id,name,id_city) VALUES (105,'Lapa',36);
INSERT INTO district (id,name,id_city) VALUES (106,'Laranjeiras',36);
INSERT INTO district (id,name,id_city) VALUES (107,'Largo do Machado',36);
INSERT INTO district (id,name,id_city) VALUES (108,'Leblon',36);
INSERT INTO district (id,name,id_city) VALUES (109,'Olaria',36);
INSERT INTO district (id,name,id_city) VALUES (110,'Pilares',36);
INSERT INTO district (id,name,id_city) VALUES (111,'Praça da Bandeira',36);
INSERT INTO district (id,name,id_city) VALUES (112,'Praça Mauá',36);
INSERT INTO district (id,name,id_city) VALUES (113,'Recreio',36);
INSERT INTO district (id,name,id_city) VALUES (114,'Santa Teresa',36);
INSERT INTO district (id,name,id_city) VALUES (115,'Santo Cristo',36);
INSERT INTO district (id,name,id_city) VALUES (116,'Taquara',36);
INSERT INTO district (id,name,id_city) VALUES (117,'Tijuca',36);
INSERT INTO district (id,name,id_city) VALUES (118,'Todos os Santos',36);
INSERT INTO district (id,name,id_city) VALUES (119,'Alto',37);
INSERT INTO district (id,name,id_city) VALUES (120,'Aterrado',38);
INSERT INTO district (id,name,id_city) VALUES (121,'Ponta Negra',39);
INSERT INTO district (id,name,id_city) VALUES (122,'Centro',40);
INSERT INTO district (id,name,id_city) VALUES (123,'Centro',41);
INSERT INTO district (id,name,id_city) VALUES (124,'Centro',42);
INSERT INTO district (id,name,id_city) VALUES (125,'Bom Fim',43);
INSERT INTO district (id,name,id_city) VALUES (126,'Centro Histórico',43);
INSERT INTO district (id,name,id_city) VALUES (127,'Cidade Baixa',43);
INSERT INTO district (id,name,id_city) VALUES (128,'Moinhos de Vento',43);
INSERT INTO district (id,name,id_city) VALUES (129,'Passo da Areia',43);
INSERT INTO district (id,name,id_city) VALUES (130,'Rio Branco',43);
INSERT INTO district (id,name,id_city) VALUES (131,'Santana',43);
INSERT INTO district (id,name,id_city) VALUES (132,'Vila Jardim',43);
INSERT INTO district (id,name,id_city) VALUES (133,'São Cristóvão',44);
INSERT INTO district (id,name,id_city) VALUES (134,'São João Bosco',44);
INSERT INTO district (id,name,id_city) VALUES (135,'Aparecida',45);
INSERT INTO district (id,name,id_city) VALUES (136,'Centro',46);
INSERT INTO district (id,name,id_city) VALUES (137,'Centro',47);
INSERT INTO district (id,name,id_city) VALUES (138,'Bairro da Velha',48);
INSERT INTO district (id,name,id_city) VALUES (139,'Itoupava Central',48);
INSERT INTO district (id,name,id_city) VALUES (140,'Itoupava Norte',48);
INSERT INTO district (id,name,id_city) VALUES (141,'Salto Weissbach',48);
INSERT INTO district (id,name,id_city) VALUES (142,'Belchior Alto',49);
INSERT INTO district (id,name,id_city) VALUES (143,'Centro',50);
INSERT INTO district (id,name,id_city) VALUES (144,'Jardim Bandeirantes',51);
INSERT INTO district (id,name,id_city) VALUES (145,'Alphaville Industrial',52);
INSERT INTO district (id,name,id_city) VALUES (146,'Tamboré',52);
INSERT INTO district (id,name,id_city) VALUES (147,'Centro',53);
INSERT INTO district (id,name,id_city) VALUES (148,'Jardim Guanabara',53);
INSERT INTO district (id,name,id_city) VALUES (149,'Jd. Santa',53);
INSERT INTO district (id,name,id_city) VALUES (150,'Vila Brandina',53);
INSERT INTO district (id,name,id_city) VALUES (151,'Parque Jataí',54);
INSERT INTO district (id,name,id_city) VALUES (152,'Vlia Cordeiro',54);
INSERT INTO district (id,name,id_city) VALUES (153,'Pontal de Santa Marina',55);
INSERT INTO district (id,name,id_city) VALUES (154,'Lageadinho',56);
INSERT INTO district (id,name,id_city) VALUES (155,'Porto Da Igreja',57);
INSERT INTO district (id,name,id_city) VALUES (156,'Jardim do Mar',58);
INSERT INTO district (id,name,id_city) VALUES (157,'Pinheiros',58);
INSERT INTO district (id,name,id_city) VALUES (158,'Vila Areal',58);
INSERT INTO district (id,name,id_city) VALUES (159,'Itaim',59);
INSERT INTO district (id,name,id_city) VALUES (160,'São Luiz',60);
INSERT INTO district (id,name,id_city) VALUES (161,'Chacara Urbana',61);
INSERT INTO district (id,name,id_city) VALUES (162,'Boituva',62);
INSERT INTO district (id,name,id_city) VALUES (163,'Centro Cívico',62);
INSERT INTO district (id,name,id_city) VALUES (164,'Bela Vista',63);
INSERT INTO district (id,name,id_city) VALUES (165,'Vila Madalena',64);
INSERT INTO district (id,name,id_city) VALUES (166,'São Dimas',65);
INSERT INTO district (id,name,id_city) VALUES (167,'Centro',66);
INSERT INTO district (id,name,id_city) VALUES (168,'Cerqueira César',66);
INSERT INTO district (id,name,id_city) VALUES (169,'Jardim California',66);
INSERT INTO district (id,name,id_city) VALUES (170,'Jardim Irajá',66);
INSERT INTO district (id,name,id_city) VALUES (171,'Matriz',66);
INSERT INTO district (id,name,id_city) VALUES (172,'Vila Do Golf',66);
INSERT INTO district (id,name,id_city) VALUES (173,'Vila Romana',66);
INSERT INTO district (id,name,id_city) VALUES (174,'Alto de Pinheiros',67);
INSERT INTO district (id,name,id_city) VALUES (175,'Jardim Tres Maria',68);
INSERT INTO district (id,name,id_city) VALUES (176,'Parque Faber Castell I',69);
INSERT INTO district (id,name,id_city) VALUES (177,'Centro',70);
INSERT INTO district (id,name,id_city) VALUES (178,'Centro',71);
INSERT INTO district (id,name,id_city) VALUES (179,'Jardim Morumbi',72);
INSERT INTO district (id,name,id_city) VALUES (180,'Jardim Walkíria',72);
INSERT INTO district (id,name,id_city) VALUES (181,'Jardim Oswaldo Cruz',73);
INSERT INTO district (id,name,id_city) VALUES (182,'Alto da Boa Vista',74);
INSERT INTO district (id,name,id_city) VALUES (183,'Alto de Pinheiros',74);
INSERT INTO district (id,name,id_city) VALUES (184,'Bela Vista',74);
INSERT INTO district (id,name,id_city) VALUES (185,'Brooklin',74);
INSERT INTO district (id,name,id_city) VALUES (186,'Brooklin Paulista',74);
INSERT INTO district (id,name,id_city) VALUES (187,'Butantã',74);
INSERT INTO district (id,name,id_city) VALUES (188,'Centro',74);
INSERT INTO district (id,name,id_city) VALUES (189,'Chácara Santo Antonio',74);
INSERT INTO district (id,name,id_city) VALUES (190,'Chácara Santo Antônio',74);
INSERT INTO district (id,name,id_city) VALUES (191,'Cidade Nova',74);
INSERT INTO district (id,name,id_city) VALUES (192,'Cidade Nova II',74);
INSERT INTO district (id,name,id_city) VALUES (193,'Consolação',74);
INSERT INTO district (id,name,id_city) VALUES (194,'Freguesia do Ó',74);
INSERT INTO district (id,name,id_city) VALUES (195,'Imirim',74);
INSERT INTO district (id,name,id_city) VALUES (196,'Indianápolis',74);
INSERT INTO district (id,name,id_city) VALUES (197,'Indianópolis',74);
INSERT INTO district (id,name,id_city) VALUES (198,'Itaim',74);
INSERT INTO district (id,name,id_city) VALUES (199,'Jardim',74);
INSERT INTO district (id,name,id_city) VALUES (200,'Jardim Das Laranjeiras',74);
INSERT INTO district (id,name,id_city) VALUES (201,'Jardim Elizabeth',74);
INSERT INTO district (id,name,id_city) VALUES (202,'Jardim Iris',74);
INSERT INTO district (id,name,id_city) VALUES (203,'Jardim Nova Aliança',74);
INSERT INTO district (id,name,id_city) VALUES (204,'Jardim Paulista',74);
INSERT INTO district (id,name,id_city) VALUES (205,'Jardim São Luiz',74);
INSERT INTO district (id,name,id_city) VALUES (206,'Jardim Sumaré',74);
INSERT INTO district (id,name,id_city) VALUES (207,'Jardim Universidade Pinheiros',74);
INSERT INTO district (id,name,id_city) VALUES (208,'Lapa',74);
INSERT INTO district (id,name,id_city) VALUES (209,'Moema',74);
INSERT INTO district (id,name,id_city) VALUES (210,'Mooca',74);
INSERT INTO district (id,name,id_city) VALUES (211,'Móoca',74);
INSERT INTO district (id,name,id_city) VALUES (212,'Morumbi',74);
INSERT INTO district (id,name,id_city) VALUES (213,'Paraíso',74);
INSERT INTO district (id,name,id_city) VALUES (214,'Penha de Franca',74);
INSERT INTO district (id,name,id_city) VALUES (215,'Perdizes',74);
INSERT INTO district (id,name,id_city) VALUES (216,'Pinheiros',74);
INSERT INTO district (id,name,id_city) VALUES (217,'Santa Cecília',74);
INSERT INTO district (id,name,id_city) VALUES (218,'Santa Cruz do José Jacques',74);
INSERT INTO district (id,name,id_city) VALUES (219,'Santana',74);
INSERT INTO district (id,name,id_city) VALUES (220,'Santo Amaro',74);
INSERT INTO district (id,name,id_city) VALUES (221,'Vila Amelia',74);
INSERT INTO district (id,name,id_city) VALUES (222,'Vila Buarque',74);
INSERT INTO district (id,name,id_city) VALUES (223,'Vila Gertrudes',74);
INSERT INTO district (id,name,id_city) VALUES (224,'Vila Lageado',74);
INSERT INTO district (id,name,id_city) VALUES (225,'Vila Leopoldina',74);
INSERT INTO district (id,name,id_city) VALUES (226,'Vila Madalena',74);
INSERT INTO district (id,name,id_city) VALUES (227,'Vila Mariana',74);
INSERT INTO district (id,name,id_city) VALUES (228,'Vila Medeiros',74);
INSERT INTO district (id,name,id_city) VALUES (229,'Vila Nova',74);
INSERT INTO district (id,name,id_city) VALUES (230,'Vila Nova Conceição',74);
INSERT INTO district (id,name,id_city) VALUES (231,'Vila Olímpia',74);
INSERT INTO district (id,name,id_city) VALUES (232,'Vila Progredior',74);
INSERT INTO district (id,name,id_city) VALUES (233,'Vila Prudente',74);
INSERT INTO district (id,name,id_city) VALUES (234,'Vila Regente Feijó',74);
INSERT INTO district (id,name,id_city) VALUES (235,'Alto de Pinheiros',75);
INSERT INTO district (id,name,id_city) VALUES (236,'Centro',76);
INSERT INTO district (id,name,id_city) VALUES (237,'Jardim Elizabeth',76);
INSERT INTO district (id,name,id_city) VALUES (238,'Vossoroca',76);
INSERT INTO district (id,name,id_city) VALUES (239,'Atalaia',77);

/*
INSERT INTO pin (id_district, name, lat, lng, address, link)
SELECT d.id AS id_district,
       i.nome,
       CAST(TRIM(substring(i.pin from 0 for POSITION(',' in i.pin))) AS float) AS lat,
       CAST(TRIM(substring(i.pin from POSITION(',' in i.pin)+1 for 1000)) AS float) AS lng,
       i.endereco,
       i.link
  FROM importacao i
  JOIN district d ON d.name = i.bairro
  JOIN city c ON c.id = d.id_city AND c.name = TRIM(i.municipio)
 ORDER BY d.id, i.lat;
*/

INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (1,'Deck - freshfood&lounge',-9.97562,-67.809105,'Av. Getulio Vargas, 178.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (1,'Chico''s Rock Bar',-9.960244,-67.813614,'Rua Alvorada, 327.','http://www.sergibeer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (2,'Mr. Beer (Parque Shopping Maceió)',-9.62698,-35.698822,'Av.Comendador Gustavo Paiva , 5945.          ','http://www.mrbeercervejas.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (3,'Casa das Cervejas',-9.645182,-35.705105,'Av. Almirante Álvaro Calheiros, 660.','http://www.casadascervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (4,'Casebre - Cervejas Especiais',0.0250857,-51.05635,'Av. Diogenes Silva, 58.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (5,'Cachaçaria do Dedé & Empório (Shopping Manauara)',-3.104392,-60.01271,'Av. Mário Ypiranga, 1300 -Rest.03 - Piso Buriti','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (6,'Cachaçaria do Dedé & Empório (Parque 10)',-3.081,-60.01057,'Rua do Comércio, 1003-F, Box 4.','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (7,'Barão Cervejas',-3.066498,-60.01222,'Av. Professor Nilton Lins, 18.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Beers & Beer (Container Mall)',-3.099491,-60.015163,'Rua Dr. Thomas, 16.','www.beersbeer.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (9,'Dom Quintas',-3.086883,-60.02411,'Av. Djalma Batista, 2010.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (9,'Frankfurt Bar',-3.073687,-59.998005,'Rua Paul Adam, 344.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (10,'Mr. Beer  (Shopping Ponta Negra)',-3.0850375,-60.072475,'Av. Coronel Teixeira, 5705.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (10,'Cachaçaria do Dedé & Empório (Shopping Ponta Negra)',-3.0850375,-60.072475,'Av. Coronel Teixeira, 5705.','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (11,'Dois Dois : Loucos por Cerveja',-3.106048,-60.01318,'Av. Mario Ypiranga, 1005, casa 17A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (12,'Biergarten Manaus',-3.0287883,-60.06558,'Av. do Turismo , 5626.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Mr. Beer (Terrazzo Villas)',-12.8833,-38.302704,'Av. Praia de Itapoan, 514.','http://www.mrbeercervejas.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (14,'Armazém Beer (Salvador Shopping)',-12.978948,-38.455143,'Av. Tancredo Neves, 3133.','http://www.armazembeerspecial.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (15,'Empório Jaguaribe',-12.958179,-38.395493,'Rua da Fauna, 177.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (16,'Armazém Beer (Shopping Paralela)',-12.936741,-38.39492,'Av. Luís Viana Filho, 8544. 2 piso.','http://www.armazembeerspecial.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (17,'Munik Boteco Gourmet',-12.991461,-38.46082,'Rua Guillard Muniz, 720.','http://www.munikbar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (18,'Rhoncus Pub & Beer Store',-13.012812,-38.48733,'Rua Oswaldo Cruz, 122.','http://www.rhoncus.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Sherlocks Pub',-3.735814,-38.506,'Rua Silva Paulet, 1222.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (20,'Empório Soares & Souza',-15.872833,-47.916935,'Aeroporto Internacional de Brasília','http://www.emporioss.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (21,'Boutique do Godofredo',-15.841727,-48.023754,'Av. Araucárias, 1325.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (21,'Empório Soares & Souza',-15.834543,-48.015717,'Rua 9 Norte, Lote 2 - Loja 4 (Ed. Montebello)','http://www.emporioss.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (22,'Santuário',-15.744748,-47.88675,'CLN 214, bloco C, Loja 27.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (22,'Pinella',-15.760143,-47.880264,'CLN 408, Bloco B, Loja 20.','http://www.pinella.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (22,'Empório Soares & Souza',-15.750905,-47.884705,'CLN 212, Bloco B, Loja 3.','http://www.emporioss.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (23,'Empório Soares & Souza',-15.809469,-47.885082,'CLS 403, Bloco D, Loja 28.','http://www.emporioss.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (24,'Mestre-Cervejeiro.com',-15.797907,-47.920513,'CLSW 301, Bloco C, Sala 158.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (25,'Boutique do Godofredo',-15.784032,-47.94804,'CLSW 101, Bloco B, 54','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (26,'Taberna Beer',-20.334269,-40.29137,'Rua 15 de Novembro, 1080.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (27,'Mr. Beer - Shopping Vitória',-20.304655,-40.292347,'Av. Américo Buaiz, 200 - Quiosque S118','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (28,'Mestre-Cervejeiro.com',-20.294674,-40.2935,'Av. Rio Branco 1726. Loja 06.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (28,'WunderBar Kaffee',-20.29493,-40.290283,'Rua Joaquim Lirio, 820.','http://www.wunderbarkaffee.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (28,'Mr. Beer - Vitória',-20.296465,-40.29192,'Rua Joaquim Lírio, 610. Loja 2.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (29,'Natur Bier',-16.700163,-49.28499,'Av. C-205, n° 413','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (29,'Garagem Pub',-16.705267,-49.291653,'Rua C.118, Q.238 L.17, n° 413 ','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (30,'Mr. Beer (Shopping Flamboyant)',-16.710197,-49.236664,'Av. Jamel Cecílio, 3300 ','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (31,'Prátaí Cult Bar',-16.712337,-49.266994,'Av. T4 Qd 169A Lt 01E n°1478','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (31,'Território do Cervejeiro',-16.695896,-49.27799,'Av. T2, 1950','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (31,'Olut',-16.692892,-49.26401,'Avenida T-4, 466.','http://www.olut.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (31,'Rash Bier',-16.692892,-49.26401,'Avenida T-003.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (32,'Pier 13',-16.693544,-49.269897,'Av.Portugal qd.L-23 lt.13 n° 818','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (32,'Velvet36 Rock’n Roll Bar',-16.695566,-49.26625,'R. 36, 378','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (33,'Edelweiss Café',-16.678843,-49.275898,'R. R2, n° 78','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (34,'Glória Bar e Restaurante',-16.685759,-49.259583,'Rua 101, 435 ','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (34,'Belgian Dash',-16.692892,-49.26401,'Rua 91, 184.','http://www.cervejasespeciais.com.br/site/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (35,'Matuto Bar',-16.681921,-49.24524,'R. 242 n° 190','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'Hops Bar',-16.685263,-49.261314,'Rua 10, 181. Galeria 10.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (37,'Buteko Lagoa',-2.493137,-44.299095,'Rua dos Maçaricos, 08.','http://www.butekos.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (38,'Ray''s American Blend',-15.590855,-56.103985,'Rua Cândido Mariano, 1351.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (38,'O''Connell''s Irish Pub',-15.591708,-56.10729,'Av. Isac Póvoas, 1548','http://www.oconnells.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (39,'Dom Agostinho Restaurante',-15.603993,-56.096394,'Av. Dom Aquino, 314.','http://dom-agostinho.blogspot.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (40,'Empório seleta',-15.586839,-56.11045,'Rua Marechal Floriano Peixoto, 1519.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (41,'Empório Serra Grande',-15.594316,-56.105534,'Rua Brigadeiro Eduardo Gomes, 305','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (42,'Originale Diparma',-15.589886,-56.106644,'Av. Senador Filinto Müller, 788.','http://www.diparma.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (42,'Hookerz',-15.587126,-56.1048,'Av. Senador Filinto Müller, 1398.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (42,'Fitz Bottega',-15.591571,-56.10271,'Rua Cândido Mariano, 1100.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (43,'Kobe Temakeria e Rolls',-15.594002,-56.10157,'Rua Presidente Marques, 1150.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (44,'Mestre-Cervejeiro.com (Rondon Plaza Shopping)',-16.470879,-54.607666,'Av. Lions International, 1950. Quiosque 16.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (45,'Casa Do Chef CG',-20.457048,-54.60184,'R. Euclides da Cunha, 360.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (46,'Maracutaia Boteco',-20.463686,-54.602325,'Rua Sete de Setembro, 1971.','http://www.maracutaiaboteco.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (47,'Chicken Beer''s',-20.397623,-54.55877,'Av. Cônsul Assaf Trad, 4796.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (48,'Morena Bier',-20.475182,-54.724453,'Av. Jamil Nahas, 236.','http://www.morenabier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'Reduto da Cerveja',-19.944645,-43.93046,'Rua Pium-í, 570.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (50,'Empório Giardino',-19.880465,-44.04159,'Alameda dos Sabiás, 393.','http://www.emporiogiardino.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (51,'Empório Veredas',-19.649862,-43.906647,'Rua Alberto Alves de Azevedo, 107.','http://www.emporioveredas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Mamãe Bebidas',-19.92236,-43.93577,'Av. do Contorno, 1955.','http://mamaebebidas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (53,'Café Viena Beer',-19.929123,-43.92189,'Av. do Contorno, 3968.','http://www.cafeviena.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (54,'Reduto da Cerveja',-19.929499,-43.944393,'Av. Álvares Cabral, 1030.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (55,'Artesanato da Cerveja (Shopping Woods)',-19.947428,-43.955204,'Rua Guaicuí, 660.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (55,'Reduto da Cerveja (Shopping Woods)',-19.947428,-43.955204,'Rua Guaicuí, 660.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (56,'Rima dos Sabores',-19.926765,-43.94404,'Rua Esmeraldas, 522.','http://www.rimadossabores.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (57,'BH Cervejas',-19.915289,-43.9553,'Rua Conselheiro Lafaiete, 510. Loja 04.','http://www.bhcervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (58,'Nórdico - Chopp Delivery e Cervejas Especiais',-19.842718,-43.974133,'Av. Deputado Anuar Menhem, 35.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (59,'Sousplat Restaurante & Sushibar',-19.907536,-43.94214,'Rua Rodrigues Caldas, 186.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (60,'Cervejaria Wäls',-19.879683,-43.962513,'Rua Padre Leopoldo Mertens, 1460.','http://www.wals.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (61,'Espetinho da Esquina',-19.926765,-43.94404,'Rua Antônio de Albuquerque, 127.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (62,'Mr. Beer Ipatinga',-22.91008,-43.177193,'Av. Pedro Linhares Gomes, 3.900','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (63,'Bendicto Gole Cervejas Especiais',-22.120026,-45.047787,'Rua Senador Câmara, 144.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (64,'Cachaçaria do Dedé & Empório (Shopping Uberlândia)',-18.957355,-48.277893,'Av. Paulo Gracindo, 15. Rest. 2.','http://www.cachacariadodede.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (65,'Mr. Beer (Belém Boulevard)',-1.4458754,-48.48914,'Av. Visconde de Souza Franco, 776. Loja Q309.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (66,'Mr. Beer (Shopping Manaira)',-7.09728,-34.835373,'Av. Governador Flavio Ribeiro Coutinho, 220. Quiosque 35.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (67,'Hooligans Pub',-24.95362,-53.469673,'Rua Paraná, 4024.','http://www.hooliganspub.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'Mestre-Cervejeiro.com',-24.951612,-53.472454,'Rua Marechal Floriano, 3278.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'Cervejaria da Vila',-25.404236,-49.271233,'Rua Mateus Leme, 2631.','http://cervejariadavila.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (70,'Hop''n Roll',-25.419075,-49.270973,'Rua Mateus Leme, 950.','http://www.hopnroll.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (71,'Mestre-Cervejeiro.com',-25.43772,-49.3241,'Rua Deputado Heitor Alencar Furtado, 1623.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (72,'Quintal do Monge',-25.427652,-49.272224,'Rua Doutor Claudino dos Santos, 24.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (73,'Mestre-Cervejeiro.com',-25.396849,-51.4731,'Rua Guaíra, 2688.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (74,'Mestre-Cervejeiro.com',-23.329456,-51.17437,'Rua João Wyclif, 500.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (75,'Pintxos Maringá Cervejas Artesanais',-23.420427,-51.928387,'Av. Pedro Tanques, 91.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (76,'Mestre-Cervejeiro.com',-22.91008,-43.177193,'Av. Doutor Francisco Burzio, 805. Loja 01.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (77,'UK Pub',-8.114876,-34.896343,'Rua Francisco da Cunha, 165.','http://www.ukpub.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (78,'Snaubar Esfiharia e Cervejaria',-8.03223,-34.914368,'Rua Doutor Virgílio Mota, 48.','http://www.snaubar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (78,'Capitão Taberna',-8.035824,-34.908962,'Rua João Tude de Melo, 77. Loja 27.','http://www.casadascervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (79,'Bierbrau Cervejas Especiais',-5.063171,-42.784252,'Av. Homero Castelo Branco, 2420.','http://www.bierbrau.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (80,'Noi Bar & Restaurante',-22.755669,-41.886845,'Rua Manoel Turíbio de Farias, 110.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (81,'Ocean Drive Empório',-22.304272,-41.696957,'Av. Atlântica, 2720. Loja 04 e 05.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (82,'Empório Icaraí Delicatessen',-22.902027,-43.109997,'Rua Mem de Sá, 111 - Loja 1','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (82,'Fina Cerva',-22.90515,-43.101387,'Av. Sete de Setembro, 193. Loja 103.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (83,'Bocca Choperia',-22.747469,-42.862003,'Av. 22 de maio, 5243.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (84,'Cervejaria e Restaurante Noi',-22.944195,-43.036217,'Est. Francisco da Cruz Nunes, 1964.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (85,'Bar & Bistrô Noi',-22.90315,-43.105213,'Rua Ministro Otávio Kelly, 174. Loja 109.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (86,'La Bière Pub',-22.918097,-43.094467,'Av. Quintino Bocaiúva, 325. Loja 117.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (86,'Restaurante Noi',-22.91732,-43.094463,'Av. Quintino Bocaiúva, 159.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (87,'Cervejaria e Restaurante Bohemia',-22.50693,-43.184982,'Rua Alfredo Pachá, 166.','http://www.cervejariabohemia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (88,'Cervejaria Cidade Imperial',-22.497028,-43.200035,'Rua Mosela, 1.341 (Módulo 01).','http://www.cidadeimperial.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Mr. Beer',-22.459572,-44.43695,'Rua Dorival Marcondes Godoy, 500. Loja 1003.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (90,'Botequim do Itahy',-22.943016,-43.340878,'Estrada de Jacarepaguá, 7544.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Mr. Beer (Shopping Metropolitano)',-22.971987,-43.373337,'Av. Embaixador Abelardo Bueno, 1300.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Mr. Beer (Barra Square Shopping Center)',-23.001225,-43.347576,'Av. Marechal Henrique Lott, 333. Bloco 02. Loja 101.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Nook Bier',-22.973904,-43.364876,'Av. Embaixador Abelardo Bueno, 1. Loja 170.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Beertaste Respect Styles - Casa Shopping',-22.992807,-43.364143,'Av. Ayrton Senna, 2150. Bloco N. Loja I.','http://www.beertaste.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Beertaste Respect Styles - Shopping Città America',-23.003107,-43.32183,'Av. das Américas, 700. Bloco B. Loja 117-E.','http://www.beertaste.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Barbearia Tradicional Navalha de Ouro - Rosa Shopping',-23.002213,-43.34956,'Av. Marechal Henrique Lott, 120. Loja 132.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (92,'Dream Beer - CADEG',-22.894735,-43.236633,'Rua  Capitão Félix, 110. Rua 13. Loja 5.','http://www.dreambeer.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Empório Farinha Pura',-22.955748,-43.19657,'Rua Voluntários da Pátria, 446.','http://www.farinhapura.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Comuna',-22.951605,-43.189972,'Rua Sorocaba, 585.','http://www.comuna.cc');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Degustare Delicatessen',-22.949554,-43.188854,'Rua Guilhermina Guinle, 296. Loja B.','http://www.degustareiguarias.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Inverso Bar',-22.954248,-43.18654,'Rua Mena Barreto, 22.','http://www.inversobar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Bar Teto Solar',-22.956171,-43.18617,'Rua Paulo Barreto, 110A.','http://www.bartetosolar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Espaço Caverna',-22.956568,-43.184685,'Rua Assis Bueno, 26.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Lupulino',-22.95147,-43.18268,'Rua Professor Álvaro Rodrigues, 148. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Boteco Colarinho',-22.94931,-43.18425,'Rua Nelson Mandela, 100. Loja 127.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (94,'Mr. Beer (Norte Shopping)',-22.887257,-43.28169,'Av. Dom Hélder Câmara, 5200. Quiosque 12A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (94,'Cervejaria Suingue (Norte Shopping)',-22.886065,-43.283264,'Av. Dom Hélder Câmara, 5474. Piso S. Loja 4506.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Jacques & Costa Barbearia e Chopp',-22.908627,-43.177505,'Av. Treze de Maio, 33. Loja 407.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'La Sagrada Familia',-22.902775,-43.17792,'Rua do Rosário, 98. Sobreloja.','http://www.lasagradafamilia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Beer Underground',-22.907034,-43.177174,'Av. Rio Branco, 156. Subsolo. Loja 101.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Dufry Shopping',-22.904928,-43.176037,'Rua da Assembléia, 51.','http://www.dufryshopping.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Bistrô CD Centro',-22.905285,-43.175957,'Rua da Quitanda, 3. Loja B.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Tabaco Café',-22.905958,-43.177376,'Av. Rio Branco, 156. Loja 121.','http://www.tabacocafe.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Taberna Bier',-22.90514,-43.174828,'Rua São José, 35, Loja 231','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Adega do Pimenta',-22.907124,-43.182022,'Praça Tiradentes, 6.','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Il Piccolo Caffè',-22.903425,-43.17606,'Rua do Carmo, 50','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Botequim do Itahy',-22.905958,-43.177376,'Av. Rio Branco, 156.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Botequim do Itahy',-22.908764,-43.17468,'Rua Araújo Porto Alegre, 56.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Monte Gordo',-22.910915,-43.177082,'Rua Senador Dantas, 44.','www.montegordo.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Al Farabi',-22.901665,-43.17558,'Rua do Rosário, 30.','http://www.alfarabi.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (96,'Dom Barcelos',-22.911768,-43.202003,'Rua Correia Vasques, 39.','http://dombarcelos.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (97,'Brasserie Brejauvas',-22.976297,-43.189217,'Rua Aires de Saldanha, 13.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (97,'Os Imortais Bar e Restaurante',-22.964487,-43.177055,'Rua Ronald de Carvalho, 147.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (97,'Doca´s Beer',-22.963566,-43.17656,'Rua Belfort Roxo, 231. Loja A.','http://docasbeer.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (97,'Pub Escondido, CA',-22.978537,-43.1898,'Rua Aires Saldanha, 98 A','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (98,'Assis Garrafaria',-22.939291,-43.196125,'Rua Cosme Velho, 174.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (99,'Mr. Beer (Shopping Nova América)',-22.848871,-43.32142,'Av. Pastor Martin Luther King Jr, 126. Anexo Novo. Quiosque QT16.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (100,'Herr Brauer',-22.933079,-43.17556,'Rua Barão do Flamengo, 35.','http://www.herrbrauer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (101,'Antiga Mercearia e Bar',-22.955748,-43.19657,'Rua Voluntários da Pátria, 446. Loja 7.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Botequim do Itahy',-22.983013,-43.206963,'Rua Maria Quitéria, 74. Loja A.','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Botequim do Itahy',-22.983093,-43.205036,'Rua Barão da Torre, 334.','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Shenanigan''s Irish Pub',-22.98446,-43.198395,'Rua Visconde de Pirajá, 112A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Bier en Cultuur',-22.983719,-43.207108,'Rua Maria Quitéria, 77.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'La Carioca Cevicheria',-22.982111,-43.209335,'Rua Garcia D''ávila, 173. Loja A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'The Ale House',-22.98369,-43.212273,'Rua Visconde de Pirajá, 580','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Delirium Café',-22.983507,-43.20134,'Rua Barão da Torre, 183.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (103,'Mr. Beer (Shopping Via Parque)',-22.982561,-43.364296,'Av. Ayrton Senna, 3000. Quiosque 55.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (104,'Gibeer',-22.964693,-43.220047,'Rua Lopes Quintas, 158.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (104,'La Carioca Cevicheria',-22.961832,-43.207783,'Rua Maria Angélica, 113A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (105,'Multifoco Bistrô',-22.912663,-43.183983,'Av. Mem de Sá, 126.','http://www.multifocobistro.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (105,'Il Piccolo Caffè Biergarten',-22.912071,-43.184677,'Rua dos Inválidos, 135.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (105,'Boteco Carioquinha',-22.913933,-43.182663,'Av. Gomes Freire, 822. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (105,'Espaço Lapa Café',-22.910784,-43.18364,'Rua Gomes Freire, 457.','http://www.espacolapacafe.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (105,'Bar do Ernesto',-22.914997,-43.177937,'Largo da Lapa, 41.','http://www.barernesto.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (106,'Boteco D.O.C.',-22.938524,-43.193104,'Rua das Laranjeiras, 486.','http://www.botecodoc.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (107,'Biergarten',-22.930307,-43.177658,'Largo do Machado, 29. Loja 202.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (108,'Botequim do Itahy',-22.985195,-43.22605,'Av Ataulfo de Paiva, 1060. ','http://www.botequimdoitahy.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (108,'Jeffrey Store',-22.979122,-43.22379,'Rua Tubira, 8.','http://www.jeffrey.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (108,'Herr Pfeffer',-22.980854,-43.22264,'Rua Conde Bernadotte, 26. Loja D.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (108,'Brewteco',-22.982948,-43.22567,'Rua Dias Ferreira, 420.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (109,'Botequim Rio Antigo',-22.84661,-43.267673,'Rua Uranos, 1489. ','http://www.botequimrioantigo.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (110,'CervejáRio',-22.886633,-43.28926,'Av. Dom Helder Câmara, 6001. Loja F. (BRSTORES)','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'Leonique Distribuidora Bebidas e Gelo',-22.922056,-43.233063,'Rua Teixeira Soares, 117.','http://www.leonique.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'The Hellish Pub',-22.913073,-43.21445,'Rua Barão de Iguatemi 292','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'Tempero da Praça',-22.913692,-43.215378,'Rua Barão de Iguatemi, 408','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'Bar da frente',-22.91346,-43.215214,'Rua Barão de Iguatemi, 388','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'Achonchego Carioca',-22.913532,-43.21516,'Rua Barão de Iguatemi, 379','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (111,'Botto Bar',-22.912807,-43.213852,'Rua Barão de Iguatemi, 205','http://www.bottobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (112,'CineBotequim',-22.898731,-43.178722,'Rua Conselheiro Saraiva, 39','http://www.cinebotequim.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (113,'Mr. Beer (Shopping Rio Design Barra)',-23.001425,-43.385902,'Av. Das Américas, 7777. Loja 332A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (113,'Mr. Beer (Américas Shopping)',-23.012585,-43.462177,'Av. Das Américas, 15500. Quiosque 5.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (113,'Itahy Premium Beer',-23.011477,-43.443108,'Av. Alfredo Balthazar da Silveira 520 Loja 101.','http://www.botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (114,'Cafecito',-22.921331,-43.18643,'Rua Paschoal Carlos Magno, 121.','http://www.cafecito.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (114,'Adega do Pimenta',-22.92066,-43.184814,'Rua Almirante Alexandrino, 296','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (115,'Balkonn Distribuidora',-22.944561,-43.287685,'Rua Pedro Alves, 240.','http://www.balkonnsab.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (115,'Bar do Omar',-22.903101,-43.20423,'Rua Sara, 114. Loja 1.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (116,'Beer e Bier Cafe',-22.919523,-43.400494,'Estrada do Rio Grande, 3486.','www.beerebier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Gato Cervejeiro',-22.923796,-43.235905,'Rua Barão de Mesquita, 356. Loja B.','http://gatocervejeiro.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Bar Rio Brasília',-22.918915,-43.213844,'Rua Almirante Gavião, 11.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Mr. Beer (Shopping Tijuca)',-22.914803,-43.22872,'Av. Maracanã, 987. Quiosque 205.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Lupulus',-22.923635,-43.229538,'Rua Conde de Bonfim, 255. Q5.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Delicatessen Nygri',-22.93217,-43.241264,'Rua. Uruguai, 380.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Malte & Cia',-22.925846,-43.24491,'Rua Barão de Mesquita, 663. Loja 19.','https://www.malteecia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Delicatessen Carioca',-22.929195,-43.243263,'Rua  Uruguai, 280.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Bobinot - Café e Bistrô',-22.931519,-43.238655,'Rua Conde de Bonfim, 615. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Confeitaria Rita de Cássia',-22.922718,-43.22222,'Rua Conde de Bonfim, 28.','http://www.confeitariaritadecassia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Yeasteria',-22.918674,-43.23931,'Rua Pereira Nunes, 266','http://yeasteria.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Benditho',-22.922293,-43.237503,'Rua Baltazar Lisboa, 47. ','http://www.bendithobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Cerveja Social Clube',-22.919855,-43.231094,'Rua Barão de Mesquita, 141. Loja C.','http://www.cervejasocialclube.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Bento',-22.918598,-43.23587,'Rua Almirante João Cândido Brasil, 134. Loja A','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (117,'Hopfen Cervejas Especiais',-22.913084,-43.227158,'Av. Maracanã, 727 - Loja H.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (118,'Confraria Cervejas Especiais',-22.890364,-43.28573,'Rua  Dr. Ferrari, 115.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (119,'Vila St. Gallen',-22.435759,-42.976345,'Rua Augusto do Amaral Peixoto, 166.','http://www.vilastgallen.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (120,'Bier Prosit Cervejas Especiais',-22.501114,-44.092907,'Av. Lucas Evangelista de Oliveira Franco, 1036.','http://www.bierprosit.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (121,'Estação do Malte',-5.881486,-35.17524,'Rua Poeta Jorge Fernandes, 146.','http://www.estacaodomalte.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (122,'Empório Canela',-29.363968,-50.81038,'Rua Felisberto Soares, 258.','http://www.emporiocanela.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (123,'Pub Garagem 23',-29.59146,-51.160336,'Av. Presidente Lucena, 3510.','http://www.pubgaragem23.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (124,'Pubis Bar',-29.674637,-51.11153,'Avenida Doutor Maurício Cardoso, 112.','http://pubis.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (124,'Barburguer - The best burguer and beer',-29.684996,-51.11944,'Rua Gomes Portinho, 822.','http://www.barburguer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (125,'Lagom Brewery & Pub',-30.034492,-51.208797,'Rua Bento Figueiredo, 72.','http://lagom.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (126,'Mestre-Cervejeiro.com (Shopping Rua da Praia)',-30.030622,-51.231377,'Rua dos Andradas, 1001. Loja 133.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (126,'Armazém Porto Alegre',-30.033094,-51.22775,'Av. Borges de Medeiros, 786.','http://armazemportoalegre.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (126,'Infiel - Bar de cervejas especiais',-30.039213,-51.219852,'Rua General Lima e Silva, 776. Loja 4.','http://www.infiel.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (127,'Apolinário Bar',-30.039808,-51.22357,'Rua José do Patrocínio, 527.','http://www.apolinariobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (127,'Malvadeza Pub',-30.038462,-51.225826,'Travessa do Carmo, 76.','http://www.malvadeza.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (128,'Bier Markt Shop',-30.026392,-51.203007,'Rua 24 de Outubro, 513, loja 1.','http://www.biermarkt.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (128,'Bier Markt Vom Fass',-30.021023,-51.203606,'Rua Barão de Santo Ângelo, 497.','http://www.biermarkt.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (128,'Lagom Brewery & Pub',-30.026108,-51.20112,'Rua Comendador Caminha, 312.','http://lagom.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (128,'Cervejomaniacos Pub e Armazém do Cervejeiro',-30.02255,-51.199448,'Rua Tobias da Silva, 229.','http://www.cervejomaniacos.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (129,'Restaurante DaDo Bier (Bourbon Shopping Country)',-30.02241,-51.16287,'Av. Túlio de Rose, 80. 2ºAndar.','http://www.dadobier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (130,'Bier Markt',-30.03061,-51.20633,'Rua Castro Alves, 442.','http://www.biermarkt.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (131,'Cuca Haus',-30.0524,-51.201378,'Rua São Luis, 1101.','http://www.cucahaus.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (132,'Boteco Mafioso',-30.035555,-51.151558,'Av. Saturnino de Brito, 738.','http://botecomafioso.blogspot.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (133,'Novo boteco',-8.758595,-63.90068,'Av. Pinheiro Machado, 1356.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (134,'Out Beer Special',-8.750431,-63.89442,'Rua João Goulart, 3002.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (135,'O Cajueiro',2.83584,-60.660065,'R. João Pereira Caldas, 54.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (136,'Mestre-Cervejeiro.com',-26.976593,-48.637127,'Av. Brasil, 146. Loja 4.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (137,'Das Bier Litoral',-26.999363,-48.630444,'Rua 2950, 426.','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (138,'Estação Vila Bar (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (138,'Choperia Alemão Batata (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (138,'Bier Vila Choperia (Vila Germânica)',-26.915844,-49.085342,'Rua Alberto Stein, 199.','https://biervila.wordpress.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (139,'Cervejaria Bierland',-26.804913,-49.087883,'Rua Gustavo Zimmermann, 5361.','http://www.bierland.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (140,'Das Bier Kneipe',-26.886635,-49.068558,'Via Expressa Paul Fritz Kuehnrich, 1600 (Shopping Park Europeu).','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (141,'Estação Eisenbahn',-26.893234,-49.126385,'Rua Bahia, 5181.','http://www.eisenbahn.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (142,'Das Bier Choperia',-26.819244,-49.024986,'Rua Bonifácio Haendchen, 5311.','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (143,'Restaurante e Pizzaria Edelweiss',-26.999765,-51.41479,'Rua Dr. Gaspar Coutinho, 439.','http://www.bierbaum.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (144,'Mr. Beer',-21.788025,-48.217247,'Av. Alberto Benassi, 2270. Quiosque Ponto D.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (145,'Mr. Beer (Iguatemi Alphaville)',-23.50466,-46.84772,'Alameda Rio Negro, 111. Quiosque 305.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (145,'Mr. Beer (Alpha Shopping)',-23.497797,-46.84871,'Alameda Rio Negro, 1033.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (146,'Mr. Beer',-23.5043,-46.8325,'Av. Piracema, 669. Quiosque E20.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (147,'Casa Amarela Rock Bar',-23.531155,-46.816204,'Rua Dr. Mariano Jatahy Marcondes Ferraz, 96','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (148,'Mr. Beer',-22.910082,-43.17717,'Av. Barão De Itapura, 2935.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (149,'Mr. Beer',-22.910082,-43.17717,'Av. Guilherme Campos, 500. Loja 430.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (150,'Mr. Beer (Iguatemi Campinas)',-22.892569,-47.02751,'Av. Iguatemi, 777. Quisoque Q106.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (151,'Cervejaria Bamberg',-23.568874,-47.459465,'Rua Sebastião Benedito Reis, 582','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (152,'Empório Bierboxx',-23.616869,-46.693527,'Rua Miguel Sutil, 358','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (153,'Mestre-Cervejeiro.com',-23.667933,-45.436535,'Av. José Herculano, 1086. Quiosque 05.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (154,'Mr. Beer (Shopping Granja Vianna)',-23.591724,-46.833847,'Rodovia Raposo Tavares, Km 23. Piso L1.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (154,'Mr. Beer (The Square Granja Vianna)',-23.589981,-46.824497,'Rodovia Raposo Tavares, Km 22. Praça das Árvores, 12.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (155,'Mr. Beer (Shopping Guarulhos)',-22.818678,-43.319645,'Rodovia Presidente Dutra, Km 230. Quiosque 35.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (156,'Einbier Cervejas Especiais',-23.688124,-46.56302,'Rua Antártico, 328-C','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (157,'Delirium Café',-23.562908,-46.697975,'Rua Ferreira de Araújo, 589','http://www.deliriumcafesp.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (158,'Mestre-Cervejeiro.com',-23.081049,-47.20818,'Av. Presidente Kennedy, 625.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (159,'Vino!',-23.583355,-46.674244,'Rua Professor Tamandaré de Toledo, 51.','www.lojavino.com.br/lojas/sp');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (160,'Mr. Beer (Plaza Itu)',-23.263985,-47.280422,'Av. Doutor Ermelindo Maffei, 1199. Quiosque A8.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (161,'Mr. Beer',-23.189285,-46.891678,'Av. Nove De Julho, 1155. Loja 206.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (162,'Velharia Pub Bar',-23.28652,-47.67246,'Rua Angelo Ribeiro, 274.','http://www.velhariapub.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (163,'Mr. Beer',-22.91008,-43.177193,'Av. Vereador Narciso Yague Guimarães, 1001. Loja QE02','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (164,'Titus Bar',-23.559551,-46.64971,'Rua Rocha, 370.','http://www.titusbar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (165,'Villa Grano',-23.556479,-46.691647,'Rua Wizard, 500.','www.villagrano.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (166,'Mestre-Cervejeiro.com',-22.711868,-47.64581,'Travessa Doná Eugênia, 402. Loja 01.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (167,'Especial Beer',-23.524836,-46.189262,'Rua 1º de Setembro, 247, Piso Superior','http://www.especialbeer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (168,'Casa da Cerveja',-23.559858,-46.67946,'Rua Lisboa, 502','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (169,'Mr. Beer (Ribeirão Shopping)',-22.91008,-43.177193,'Av. Coronel Fernando Ferreira Leite, 1540. Quiosque 147.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (170,'Mr. Beer',-21.20616,-47.806946,'Rua Do Professor, 499. Sala 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (171,'Don Corleone Bar e Petiscaria',-23.67286,-46.460133,'Av. Dom José Gaspar, 458','http://doncorleonebar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (172,'Mr. Beer (Iguatemi Ribeirao Preto)',-21.225788,-47.835285,'Av. Luiz Eduardo Toledo Prado, 900. Loja 1062.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (173,'Cerveja Gourmet',-23.527987,-46.695393,'Rua Tito 400','http://cervejagourmet.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (174,'Melograno',-23.557507,-46.6897,'Rua Aspicuelta, 436','www.melograno.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (175,'Mr. Beer (Golden Square)',-23.684095,-46.558376,'Av. Kennedy, 700. Loja 186.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (176,'Mr. Beer (Iguatemi São Carlos)',-22.01744,-47.915813,'Passeio Dos Flamboyants, 200. Quiosque 102.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (177,'Mr. Beer',-21.97629,-46.798244,'Rua Santo Antonio, 32.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (178,'Kingsford Pub',-23.496601,-47.465298,'Av. Dr. Afonso Vergueiro, 1479','https://www.facebook.com/kingsfordpub');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (179,'Mr. Beer (Riopreto Shopping)',-20.835062,-49.39854,'Av Brigadeiro Faria Lima, 6363. Loja 198.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (180,'Mr. Beer (Plaza Avenida Shopping)',-20.827705,-49.388004,'Av. José Munia, 4775. Loja 176A.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (181,'Mr. Beer (Center Vale)',-23.200306,-45.880802,'Av. Deputado Benedito Matarazzo, 9403. Quiosque QV 06.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (182,'Cervejarium',-21.20246,-47.819183,'Av. Independência, 3242','http://www.cervejarium.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (182,'Cervejarium',-21.20246,-47.819183,'Av. Independência, 3.242','www.coloradocervejarium.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (183,'Empório Sagarana',-23.556772,-46.688087,'Rua Aspicuelta, 271','www.emporiosagarana.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (184,'Mr. Beer (Top Center)',-23.56595,-46.65064,'Av. Paulista, 854. Q13.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (184,'Mr. Beer (Shopping Center 3)',-23.55876,-46.65939,'Av. Paulista, 2064. Quiosque 4.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (185,'Tortula',-23.621655,-46.683903,'Av. Santo Amaro, 4.371.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (186,'Mr. Beer (Shopping D&D)',-23.60862,-46.697124,'Av. Das Nações Unidas, 12551. Loja 108A.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (187,'Cervejaria Ô Fiô',-23.585918,-46.718243,'Rua Lício Marcondes do Amaral, 51','cervejariaofio.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (188,'Nosso Bar',-22.905716,-47.057983,'Rua Barão de Jaguara, 988, Box 02.','http://nossobarcervejasespeciais.blogspot.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (188,'Butréco Butiquim',-20.80123,-49.385937,'Rua Pedro Amaral, 1822','https://www.facebook.com/butreco.butiquim');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (188,'BRB-Blues Rock Beer',-24.320168,-47.00489,'Avenida 24 de Dezembro, 45','https://www.facebook.com/pages/BRB-Blues-Rock-Beer/306320206070196');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (188,'Bar Brejas',-22.902262,-47.051723,'Rua Conceição, 860','barbrejas.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (189,'Laus Beer Loja',-23.634203,-46.698795,'Rua Fernandes Moreira, 384','www.santebar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (190,'Mr. Beer',-23.63345,-46.70532,'Rua Verbo Divino, 986. Quiosque 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (191,'Mundo Beer',-23.08578,-47.207096,'Avenida Itororó, 681.','https://www.facebook.com/mundobeerindaiatuba');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (192,'Bendito Malte',-23.076614,-47.201168,'Av. Conceição, 1950','https://www.facebook.com/benditomalte');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (193,'Cervejaria Devassa - Bela Cintra',-23.559643,-46.665268,'Rua Bela Cintra, 1.579','http://www.cervejariadevassa.com.br/index.php/unidades/bela-cintra');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (194,'FrangÓ',-23.50113,-46.69858,'Lg. da Matriz da N. S. do Ó, 168','frangobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (195,'Leão da Terra',-23.487091,-46.643192,'Av. Engenheiro Caetano Álvares, 4666','http://www.leaodaterra.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (196,'Belgian Beer Paradise',-23.60487,-46.666813,'Av. Ibijaú, 196','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (197,'Mr. Beer',-23.61098,-46.66924,'Av. Ibirapuera, 3103. Quiosque 50.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (198,'Coisa Boa',-23.582058,-46.679195,'Rua Pedroso Alvarenga, 909','https://www.facebook.com/coisaboabar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (199,'Asgard Pub',-23.654701,-46.53594,'Rua das Bandeiras, 421','http://www.asgardpub.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (200,'Mr. Beer',-23.509266,-46.661686,'Rua Relíquia, 383. Quiosque 1.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (201,'Fräulein Bierhaus',-22.718636,-45.565983,'Rua Isola Orsi, 33','http://www.fraulein.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (202,'Mr. Beer (Plaza Tiete)',-23.506273,-46.717285,'Av. Raimundo Pereira De Magalhães, 1465. Quiosque 105.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (203,'Empório Biergarten',-21.215042,-47.823734,'Av. Lygia Latuf Salomão, 605, Mercadão da Cidade - Box 83','www.emporiobiergarten.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (204,'Karavelle Brew Pub',-23.562187,-46.667713,'Alameda Lorena, 1784','http://www.karavelle.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (204,'Bar Asterix',-23.56668,-46.651367,'Alameda Joaquim Eugênio de Lima, 573','http://www.barasterix.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (204,'Asterix',-23.56673,-46.651382,'Alameda Joaquim Eugênio de Lima, 575','www.barasterix.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (204,'All Black',-23.56768,-46.663925,'Rua Oscar Freire, 163','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (204,'Aconchego Carioca',-23.560913,-46.660667,'Alameda Jaú, 1.372','http://www.facebook.com/aconchegocariocasp');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (205,'Mr. Beer',-23.648783,-46.73095,'Av. Maria Coelho Águiar, 215.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (206,'Bar Vila Dionísio Ribeirão Preto',-21.18738,-47.811146,'Rua Eliseu Guilherme, 567','http://www.viladionisio.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (207,'Mr. Beer',-23.591919,-46.691715,'Av. Das Nações Unidas, 4777.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (208,'Bezerra',-23.52592,-46.69301,'Rua Coriolano, 800','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (209,'Bier Bär',-23.59948,-46.66807,'Rua Tuim, 253','http://www.bierbar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (210,'A Boa Cerveja',-23.557463,-46.595947,'Rua Capitães Mores, 414','http://www.aboacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (211,'1ª Cervejaria da Móoca',-23.56254,-46.593426,'Rua Guaimbê, 148','www.primeiracervejariadamooca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (212,'Market Place - Laus Beer Quiosque',-23.621418,-46.69904,'Av. Dr. Chucri Zaidan, 902','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (213,'Adega Tutóia',-23.574245,-46.651962,'Rua Tutóia, 260.','http://www.adegatutoia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (214,'Armazém 77',-23.529026,-46.545315,'Rua Betari, 520','https://www.facebook.com/armazem77');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (215,'Mestre-Cervejeiro.com',-23.536154,-46.681114,'Rua Vanderlei, 1595.','www.mestre-cervejeiro.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (216,'Mr. Beer',-23.562468,-46.67521,'Av. Rebouças, 3970. Quiosque Q56.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (216,'BrewDog Bar',-23.56137,-46.693886,'Rua dos Coropés, 41','https://www.facebook.com/brewdogsaopaulo/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (216,'Beer Legends - Bar e Cervejaria',-23.558302,-46.691246,'Rua Mourato Coelho, 1112','http://www.beerlegends.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (216,'Bar Cervejaria Nacional',-23.56475,-46.690678,'Avenida Pedroso de Morais, 604','http://www.cervejarianacional.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (216,'Arturito',-23.559944,-46.67758,'Rua Artur de Azevedo, 542','www.arturito.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (217,'Rota do Acarajé',-23.541315,-46.654236,'Rua Martim Francisco, 529.','www.rotadoacaraje.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (218,'Spader Bar',-21.200386,-47.800735,'Rua Humaita, 80.','https://www.facebook.com/spaderbar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (219,'Empório Laura Aguiar',-23.502054,-46.62067,'Rua Gabriel Piza, 559','http://emporiolauraaguiar.blogspot.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (220,'Tchê Café',-23.63084,-46.668568,'Av. Washington Luis, 5628.','http://www.tchecafe.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (221,'Cervejaria Invicta',-21.17494,-47.830826,'Avenida do Café, 1365','https://www.facebook.com/CervejariaInvictaBar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (222,'The Joy',-23.54593,-46.65131,'Rua Maria Antônia, 330.','http://www.thejoy.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (223,'Mr. Beer (Market Place)',-23.593897,-46.692265,'Av. Das Nações Unidas, 13947. Quiosque 104.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (224,'Pay Per Beer',-22.909958,-43.177197,'Rua Professor Herbert Baldus, 125.','http://www.payperbeer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (225,'Mr. Beer',-23.524837,-46.733208,'Rua Carlos Weber, 382. Loja 02.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (226,'BierBoxx',-23.559673,-46.68895,'Rua Fradique Coutinho,842','http://barbierboxx.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (227,'Let''s Beer',-23.586386,-46.641716,'Rua Joaquim Távora, 961.','http://www.letsbeer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (227,'Pier 1327',-23.587671,-46.64509,'Rua Joaquim Távora, 1327.','http://www.pier1327.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (227,'Beer Bamboo',-22.909958,-43.177197,'Rua Joaquim Távora, 895.','http://www.beerbamboo.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (228,'Mocotó',-23.48669,-46.581673,'Av. Nossa Senhora do Loreto, 1.100','www.mocoto.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (229,'Confrades Bier Shop',-23.275764,-47.29078,'Av. Prudente de Moraes, 210','http://cervejariaconfrades.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (230,'Mr. Beer',-23.591228,-46.67678,'Rua Doutor Alceu de Campos Rodrigues, 476.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (230,'Kia Ora Pub',-23.588879,-46.6754,'Rua Doutor Eduardo de Souza Aranha, 377','www.kiaora.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (231,'Rock Fella Burgers & Beers',-23.59373,-46.68475,'Rua Rócio, 89.','http://www.facebook.com/RockFellaBurgersBeers');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (232,'Mr. Beer',-23.594715,-46.72052,'Av. Jorge João Saad, 900. Sobreloja 6.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (233,'Mr. Beer (Mooca Plaza Shopping)',-23.579807,-46.594517,'Rua Capitão Pacheco e Chaves, 313. Quadra 11. Loja 2.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (234,'Mr. Beer',-23.553097,-46.563496,'Rua Emília Marengo, 383.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (235,'Empório Alto dos Pinheiros',-23.559996,-46.69952,'Rua Vupabussu, 305','www.eapsp.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (236,'The Square Pub',-22.910465,-43.179558,'Rua Teófilo David Muzel, 100.','http://www.thesquarepub.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (237,'Cervejaria Baden Baden',-22.718983,-45.567295,'Rua Dr. Djalma Forjaz, 93','www.obadenbaden.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (238,'Mr. Beer (Iguatemi Sorocaba)',-22.951702,-43.37692,'Av. Gisele Constantino, 1800. Loja 124B.','http://www.mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (239,'Calles Bar de Tapas',-10.990155,-37.049873,'Avenida Santos Dumont, 188.','');

UPDATE pin SET enabled = created;
UPDATE pin SET enabled_by = 'vitor.mattos@gmail.com';
UPDATE pin SET created_by = 'vitor.mattos@gmail.com';

INSERT INTO phone_type (type) VALUES ('Empresarial');
INSERT INTO phone_type (type) VALUES ('Celular');
INSERT INTO phone_type (type) VALUES ('Outros');

/*
INSERT INTO phone(number, id_phone_type, entity, id_entity)
SELECT x.number,
       CASE WHEN SUBSTRING(x.number, 3, 1) = 9
              OR (
                      LENGTH(x.number) = 11
                  AND SUBSTRING(x.number, 1, 1) <> 0
                 ) THEN 2
            ELSE 1
        END AS id_phone_type,
       x.entity,
       x.id
  FROM (
         SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(i.telefone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', '') AS number,
                'pin' AS entity,
                i.id
           FROM importacao i
           JOIN pin p ON p.name = i.nome AND p.address = i.endereco
           WHERE length(i.telefone) > 0
       ) AS x
*/

INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6832236627','pin',1);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6833016224','pin',2);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8230336028','pin',3);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'8291518116','pin',4);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9681217883','pin',5);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9233024613','pin',7);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9236320350','pin',8);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9232360025','pin',9);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9236677303','pin',10);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9232366642','pin',11);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9232325471','pin',12);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9233436880','pin',14);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9233460777','pin',15);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7130194344','pin',16);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7133673536','pin',17);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7134522746','pin',18);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7141035406','pin',19);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7141112636','pin',20);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7135084721','pin',21);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8230336028','pin',22);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6135326702','pin',23);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'6130849306‎','pin',24);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6133649443','pin',25);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'6139637022‎','pin',26);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6133478334','pin',27);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6130216500','pin',28);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6135675527','pin',29);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6130395667','pin',30);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6130216667','pin',31);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2733171446','pin',32);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2733256711','pin',33);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2732291643','pin',34);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2732274331','pin',35);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2733158908','pin',36);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6236365082','pin',37);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6232186792','pin',38);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6230864928','pin',39);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239201316','pin',40);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9832680044','pin',41);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6541413876','pin',42);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530540997','pin',43);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530525387','pin',44);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530543616','pin',45);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6536242748','pin',46);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530230287','pin',47);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530239008','pin',48);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6521270583','pin',49);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6530528450','pin',50);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6630225011','pin',51);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6732010999','pin',52);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6733637958','pin',53);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'6792326911','pin',54);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6781990890','pin',55);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3132438824','pin',56);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3134432811','pin',57);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3533314806','pin',58);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125151770','pin',59);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3133177974','pin',60);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125119680','pin',61);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3132219555','pin',62);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3132139494','pin',63);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125730239','pin',64);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125164181','pin',65);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125310660','pin',66);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'3199541088','pin',67);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3132437120','pin',68);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3133969584','pin',69);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3125101377','pin',70);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3432256200','pin',71);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'3186519495','pin',72);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9181187565','pin',73);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8321066401','pin',74);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4488060825','pin',75);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4134084486','pin',76);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4130154620','pin',77);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4132325679','pin',78);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4530390072','pin',79);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4230273087','pin',80);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4230361377','pin',81);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4530372690','pin',82);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4130726921','pin',83);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4333452015','pin',84);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8132048668','pin',85);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8134669192','pin',86);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8132045104','pin',87);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8632332430','pin',88);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2126421575','pin',89);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2124560705','pin',90);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2433467612','pin',91);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2132815339','pin',95);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'21995103815','pin',96);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2130959239','pin',97);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2137963435','pin',103);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125276909','pin',104);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2130290789','pin',105);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2132398000','pin',106);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'21995416922','pin',108);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122401017','pin',112);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122620190','pin',113);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2141096301','pin',116);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122202156','pin',117);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125245338','pin',118);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'08007238379','pin',119);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125129919','pin',120);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125229800','pin',122);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2131178082','pin',123);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2135638959','pin',124);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125488964','pin',125);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122053598','pin',126);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2135460945','pin',127);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2127146348','pin',130);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2126107175','pin',131);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122675860','pin',136);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2126353554','pin',137);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2127093939','pin',138);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'21979625442','pin',139);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2137412945','pin',142);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2227571336','pin',143);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122223034','pin',148);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122740000','pin',153);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2422204800','pin',155);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2138676124','pin',156);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'24998137323','pin',157);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2135471999','pin',158);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2134967407','pin',159);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'21995103815','pin',166);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'21995103815','pin',167);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2140636210','pin',171);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2126110619','pin',172);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2127107390','pin',173);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2137969809','pin',178);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2135793003','pin',179);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122641517','pin',180);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2121430077','pin',181);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125713497','pin',182);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2132385832','pin',183);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122686896','pin',184);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2132282720','pin',185);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122010446','pin',186);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125333861','pin',188);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122522240','pin',189);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2135983170','pin',190);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2125222919','pin',191);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122473356','pin',192);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2122591999','pin',193);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'8433463919','pin',194);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130724800','pin',195);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5131088616','pin',196);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5182238223','pin',197);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5132173826','pin',198);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130655661','pin',199);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5430311000','pin',200);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5132217833','pin',201);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130625045','pin',202);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130266660','pin',203);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130130158','pin',204);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'5191021010','pin',205);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5135740927','pin',206);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5132082300','pin',207);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130132300','pin',208);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5135192555','pin',209);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5133783000','pin',210);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5132260308','pin',211);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'5130611002','pin',212);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6932241855','pin',213);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6930434001','pin',214);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'9536235377','pin',215);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4935370531','pin',216);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733373100','pin',217);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733290808','pin',218);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733294242','pin',219);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733978600','pin',220);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4734887371','pin',221);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733977519','pin',222);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733633030','pin',223);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733292121','pin',224);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'4733440125','pin',225);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1126045275','pin',226);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1126150512','pin',227);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130628262','pin',228);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138844343','pin',229);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135646899','pin',231);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130634951','pin',232);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1149026035','pin',233);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1133685610','pin',234);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1133685610','pin',235);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1932517912','pin',236);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136285000','pin',237);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1636107416','pin',238);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138951565','pin',239);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1129259422','pin',240);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138624646','pin',243);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1150516695','pin',244);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138050151','pin',245);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'13997042330','pin',246);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130324007','pin',247);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1732343141','pin',248);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136854500','pin',249);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136750761','pin',251);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1236636082','pin',252);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130816081','pin',254);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1638781020','pin',255);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1137216636','pin',256);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1639114949','pin',257);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1639114949','pin',258);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130730773','pin',259);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11967741215','pin',260);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1124952225','pin',261);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1134201966','pin',262);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1143174008','pin',263);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130314328','pin',264);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1632370722','pin',266);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1129770471','pin',267);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130310816','pin',268);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1143128902','pin',269);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1139324818','pin',270);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1236631529','pin',271);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130453597','pin',273);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1533461064','pin',274);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135670569','pin',275);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136249056','pin',276);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130312921','pin',278);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1934321728','pin',279);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1238859676','pin',280);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1933941377','pin',281);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138713911','pin',282);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1129513056','pin',283);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1632142024','pin',284);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11982250346','pin',285);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1141950235','pin',286);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11982250346','pin',287);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11968501274','pin',288);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1932534604','pin',289);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1932912117','pin',290);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11953136727','pin',291);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1147023344','pin',292);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1124141268','pin',293);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1127150599','pin',294);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11996887535','pin',295);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1147254503','pin',296);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1639132995','pin',297);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1633292753','pin',298);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1636212389','pin',299);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1178991141','pin',300);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1634197005','pin',301);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'19997006085','pin',302);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1730339820','pin',303);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1733046691','pin',304);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1239132455','pin',305);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1125335676','pin',306);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135895805','pin',307);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239418549','pin',346);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1137418222','pin',308);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11987753665','pin',309);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1121977907','pin',310);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1150933978','pin',311);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1143242618','pin',312);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1151818569','pin',313);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135484645','pin',314);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1125375380','pin',315);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1122356382','pin',316);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130439082','pin',317);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11948706483','pin',318);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135696162','pin',319);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1123092694','pin',320);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'11963966727','pin',321);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1532475943','pin',322);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1933295735','pin',323);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1932339498','pin',324);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1135424730','pin',325);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1155396213','pin',326);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136686222','pin',328);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1631015410','pin',329);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1150317537','pin',330);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1136280691','pin',331);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1535224150','pin',332);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1133845595','pin',333);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,'15998347201','pin',335);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1138132725','pin',336);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1130786442','pin',337);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'7930252725','pin',338);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2131971278','pin',339);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'2131733008','pin',340);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'1125899695','pin',341);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6238777954','pin',342);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239327497','pin',343);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239411708','pin',344);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239240459','pin',345);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239549760','pin',347);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239321454','pin',348);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6232857541','pin',349);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6232249033','pin',350);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,'6239261313','pin',351);
");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('phone');
        $this->dropTable('phone_type');
        $this->dropTable('pin');
        $this->dropTable('district');
        $this->dropTable('city');
        $this->dropTable('state');
        $this->dropTable('country');
    }
}