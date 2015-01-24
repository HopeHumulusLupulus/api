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
            ->addColumn('lat', 'biginteger')
            ->addColumn('lng', 'biginteger')
            ->addColumn('address', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('link', 'string', array('limit' => 150, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_district', $district, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $pin->save();

        $phone_type = $this->table('phone_type')
            ->addColumn('type', 'string', array('limit' => 15));
        $phone_type->save();

        $phone = $this->table('phone')
            ->addColumn('id_phone_type', 'integer')
            ->addColumn('number', 'biginteger')
            ->addColumn('entity', 'string', array('limit' => 40))
            ->addColumn('id_entity', 'integer')
            ->addColumn('other_type', 'string', array('limit' => 40, 'null' => true))
            ->addColumn('created', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addForeignKey('id_phone_type', $phone_type, 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'));
        $phone->save();

        $this->execute("
/* tabela de importação
CREATE TABLE `importacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `pin` varchar(100) DEFAULT NULL,
  `lat` int(11) DEFAULT NULL,
  `lng` int(11) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `seg1` varchar(45) DEFAULT NULL,
  `seg2` varchar(45) DEFAULT NULL,
  `ter1` varchar(45) DEFAULT NULL,
  `ter2` varchar(45) DEFAULT NULL,
  `qua1` varchar(45) DEFAULT NULL,
  `qua2` varchar(45) DEFAULT NULL,
  `qui1` varchar(45) DEFAULT NULL,
  `qui2` varchar(45) DEFAULT NULL,
  `sex1` varchar(45) DEFAULT NULL,
  `sex2` varchar(45) DEFAULT NULL,
  `sab1` varchar(45) DEFAULT NULL,
  `sab2` varchar(45) DEFAULT NULL,
  `dom1` varchar(45) DEFAULT NULL,
  `dom2` varchar(45) DEFAULT NULL,
  `local` varchar(45) DEFAULT NULL,
  `chope` varchar(45) DEFAULT NULL,
  `cerveja` varchar(45) DEFAULT NULL,
  `cg` varchar(45) DEFAULT NULL,
  `cp` varchar(45) DEFAULT NULL,
  `comida` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

INSERT INTO country (name) VALUES('Brasil');

/*
INSERT INTO state(name, id_country)
SELECT i.estado, 1
  FROM importacao i
  JOIN state s ON s.name <> TRIM(i.estado)
 GROUP BY i.estado;
*/

INSERT INTO `state` (name,id_country) VALUES ('Rio de Janeiro',1);
INSERT INTO `state` (name,id_country) VALUES ('Espírito Santo',1);
INSERT INTO `state` (name,id_country) VALUES ('Goiás',1);
INSERT INTO `state` (name,id_country) VALUES ('Minas Gerais',1);
INSERT INTO `state` (name,id_country) VALUES ('Santa Catarina',1);
INSERT INTO `state` (name,id_country) VALUES ('São Paulo',1);

/*
INSERT INTO city(name, id_state)
SELECT i.municipio, s.id
  FROM importacao i
  JOIN city c ON c.name <> TRIM(i.municipio)
  JOIN state s ON s.name = TRIM(i.estado)
 GROUP BY i.municipio;
*/

INSERT INTO `city` (name,id_state) VALUES ('Búzios',1);
INSERT INTO `city` (name,id_state) VALUES ('Macaé',1);
INSERT INTO `city` (name,id_state) VALUES ('Niterói',1);
INSERT INTO `city` (name,id_state) VALUES ('Petrópolis',1);
INSERT INTO `city` (name,id_state) VALUES ('Resende',1);
INSERT INTO `city` (name,id_state) VALUES ('Rio de Janeiro',1);
INSERT INTO `city` (name,id_state) VALUES ('Teresópolis',1);
INSERT INTO `city` (name,id_state) VALUES ('Volta Redonda',1);
INSERT INTO `city` (name,id_state) VALUES ('Balneário de Camboriú',5);
INSERT INTO `city` (name,id_state) VALUES ('Belo Horizonte',4);
INSERT INTO `city` (name,id_state) VALUES ('Blumenau',5);
INSERT INTO `city` (name,id_state) VALUES ('Búzios',1);
INSERT INTO `city` (name,id_state) VALUES ('Campinas',6);
INSERT INTO `city` (name,id_state) VALUES ('Campos do Jordão',6);
INSERT INTO `city` (name,id_state) VALUES ('Gaspar',5);
INSERT INTO `city` (name,id_state) VALUES ('Goiânia',3);
INSERT INTO `city` (name,id_state) VALUES ('Indaiatuba',6);
INSERT INTO `city` (name,id_state) VALUES ('Macaé',1);
INSERT INTO `city` (name,id_state) VALUES ('Niterói',1);
INSERT INTO `city` (name,id_state) VALUES ('Petrópolis',1);
INSERT INTO `city` (name,id_state) VALUES ('Resende',1);
INSERT INTO `city` (name,id_state) VALUES ('Ribeirão Preto',6);
INSERT INTO `city` (name,id_state) VALUES ('Rio de Janeiro',1);
INSERT INTO `city` (name,id_state) VALUES ('Santo André',6);
INSERT INTO `city` (name,id_state) VALUES ('São Bernardo do Campo',6);
INSERT INTO `city` (name,id_state) VALUES ('São José do Rio Preto',6);
INSERT INTO `city` (name,id_state) VALUES ('São Lourenço',4);
INSERT INTO `city` (name,id_state) VALUES ('São Paulo',6);
INSERT INTO `city` (name,id_state) VALUES ('Sorocaba',6);
INSERT INTO `city` (name,id_state) VALUES ('Teresópolis',1);
INSERT INTO `city` (name,id_state) VALUES ('Treze Tílias',5);
INSERT INTO `city` (name,id_state) VALUES ('Vitória',2);
INSERT INTO `city` (name,id_state) VALUES ('Volta Redonda',1);
INSERT INTO `city` (name,id_state) VALUES ('Votorantim',6);

/*
INSERT INTO district(name, id_city)
SELECT i.bairro, c.id
  FROM importacao i
  JOIN city c ON c.name = TRIM(i.municipio)
 GROUP BY i.bairro;
*/

INSERT INTO district (name,id_city) VALUES ('Alto',7);
INSERT INTO district (name,id_city) VALUES ('Alto da Boa Vista',22);
INSERT INTO district (name,id_city) VALUES ('Alto de Pinheiros',28);
INSERT INTO district (name,id_city) VALUES ('Anchieta',10);
INSERT INTO district (name,id_city) VALUES ('Anil',6);
INSERT INTO district (name,id_city) VALUES ('Aterrado',8);
INSERT INTO district (name,id_city) VALUES ('Bairro da Velha',11);
INSERT INTO district (name,id_city) VALUES ('Barra da Tijuca',6);
INSERT INTO district (name,id_city) VALUES ('Bela Vista',28);
INSERT INTO district (name,id_city) VALUES ('Belchior Alto',15);
INSERT INTO district (name,id_city) VALUES ('Benfica',6);
INSERT INTO district (name,id_city) VALUES ('Boituva',28);
INSERT INTO district (name,id_city) VALUES ('Botafogo',6);
INSERT INTO district (name,id_city) VALUES ('Brooklin',28);
INSERT INTO district (name,id_city) VALUES ('Butantã',28);
INSERT INTO district (name,id_city) VALUES ('Cabral',10);
INSERT INTO district (name,id_city) VALUES ('Cachambi',6);
INSERT INTO district (name,id_city) VALUES ('Castelo',10);
INSERT INTO district (name,id_city) VALUES ('Centro',6);
INSERT INTO district (name,id_city) VALUES ('Cerqueira César',28);
INSERT INTO district (name,id_city) VALUES ('Chácara Santo Antonio',28);
INSERT INTO district (name,id_city) VALUES ('Cidade Nova',6);
INSERT INTO district (name,id_city) VALUES ('Cidade Nova II',17);
INSERT INTO district (name,id_city) VALUES ('Consolação',28);
INSERT INTO district (name,id_city) VALUES ('Copacabana',6);
INSERT INTO district (name,id_city) VALUES ('Cosme Velho',6);
INSERT INTO district (name,id_city) VALUES ('Del Castilho',6);
INSERT INTO district (name,id_city) VALUES ('Flamengo',6);
INSERT INTO district (name,id_city) VALUES ('Floresta',10);
INSERT INTO district (name,id_city) VALUES ('Freguesia do Ó',28);
INSERT INTO district (name,id_city) VALUES ('Funcionários',10);
INSERT INTO district (name,id_city) VALUES ('Humaitá',6);
INSERT INTO district (name,id_city) VALUES ('Icaraí',3);
INSERT INTO district (name,id_city) VALUES ('Imirim',28);
INSERT INTO district (name,id_city) VALUES ('Indianápolis',28);
INSERT INTO district (name,id_city) VALUES ('Ipanema',6);
INSERT INTO district (name,id_city) VALUES ('Itaboraí',3);
INSERT INTO district (name,id_city) VALUES ('Itaim',28);
INSERT INTO district (name,id_city) VALUES ('Itaipu',3);
INSERT INTO district (name,id_city) VALUES ('Itoupava Central',11);
INSERT INTO district (name,id_city) VALUES ('Itoupava Norte',11);
INSERT INTO district (name,id_city) VALUES ('Jacarepaguá',6);
INSERT INTO district (name,id_city) VALUES ('Jardim',24);
INSERT INTO district (name,id_city) VALUES ('Jardim Botânico',6);
INSERT INTO district (name,id_city) VALUES ('Jardim do Mar',25);
INSERT INTO district (name,id_city) VALUES ('Jardim Elizabeth',14);
INSERT INTO district (name,id_city) VALUES ('Jardim Icaraí',3);
INSERT INTO district (name,id_city) VALUES ('Jardim Nova Aliança',22);
INSERT INTO district (name,id_city) VALUES ('Jardim Paulista',28);
INSERT INTO district (name,id_city) VALUES ('Jardim Sumaré',22);
INSERT INTO district (name,id_city) VALUES ('Lagomar',2);
INSERT INTO district (name,id_city) VALUES ('Lapa',6);
INSERT INTO district (name,id_city) VALUES ('Laranjeiras',6);
INSERT INTO district (name,id_city) VALUES ('Largo do Machado',6);
INSERT INTO district (name,id_city) VALUES ('Leblon',6);
INSERT INTO district (name,id_city) VALUES ('Lot. Triângulo de Búzios',1);
INSERT INTO district (name,id_city) VALUES ('Lourdes',10);
INSERT INTO district (name,id_city) VALUES ('Luxemburgo',10);
INSERT INTO district (name,id_city) VALUES ('Matriz',24);
INSERT INTO district (name,id_city) VALUES ('Moema',28);
INSERT INTO district (name,id_city) VALUES ('Móoca',28);
INSERT INTO district (name,id_city) VALUES ('Morumbi',28);
INSERT INTO district (name,id_city) VALUES ('Mosela',4);
INSERT INTO district (name,id_city) VALUES ('Olaria',6);
INSERT INTO district (name,id_city) VALUES ('Paraíso',5);
INSERT INTO district (name,id_city) VALUES ('Parque Jataí',34);
INSERT INTO district (name,id_city) VALUES ('Pilares',6);
INSERT INTO district (name,id_city) VALUES ('Pinheiros',28);
INSERT INTO district (name,id_city) VALUES ('Praça da Bandeira',6);
INSERT INTO district (name,id_city) VALUES ('Praça Mauá',6);
INSERT INTO district (name,id_city) VALUES ('Prado',10);
INSERT INTO district (name,id_city) VALUES ('Praia do Canto',32);
INSERT INTO district (name,id_city) VALUES ('Recreio',6);
INSERT INTO district (name,id_city) VALUES ('Sagrada Família',10);
INSERT INTO district (name,id_city) VALUES ('Salto Weissbach',11);
INSERT INTO district (name,id_city) VALUES ('Santa Amelia',10);
INSERT INTO district (name,id_city) VALUES ('Santa Cecília',28);
INSERT INTO district (name,id_city) VALUES ('Santa Cruz do José Jacques',22);
INSERT INTO district (name,id_city) VALUES ('Santa Teresa',6);
INSERT INTO district (name,id_city) VALUES ('Santana',28);
INSERT INTO district (name,id_city) VALUES ('Santo Agostinho',10);
INSERT INTO district (name,id_city) VALUES ('Santo Amaro',28);
INSERT INTO district (name,id_city) VALUES ('Santo Cristo',6);
INSERT INTO district (name,id_city) VALUES ('São Francisco',3);
INSERT INTO district (name,id_city) VALUES ('Savassi',10);
INSERT INTO district (name,id_city) VALUES ('Setor Bueno',16);
INSERT INTO district (name,id_city) VALUES ('Setor Sul',16);
INSERT INTO district (name,id_city) VALUES ('Taquara',6);
INSERT INTO district (name,id_city) VALUES ('Tijuca',6);
INSERT INTO district (name,id_city) VALUES ('Todos os Santos',6);
INSERT INTO district (name,id_city) VALUES ('Vila Amelia',22);
INSERT INTO district (name,id_city) VALUES ('Vila Buarque',28);
INSERT INTO district (name,id_city) VALUES ('Vila Lageado',28);
INSERT INTO district (name,id_city) VALUES ('Vila Madalena',28);
INSERT INTO district (name,id_city) VALUES ('Vila Mariana',28);
INSERT INTO district (name,id_city) VALUES ('Vila Medeiros',28);
INSERT INTO district (name,id_city) VALUES ('Vila Nova',28);
INSERT INTO district (name,id_city) VALUES ('Vila Nova Conceição',28);
INSERT INTO district (name,id_city) VALUES ('Vila Olímpia',28);
INSERT INTO district (name,id_city) VALUES ('Vila Romana',28);
INSERT INTO district (name,id_city) VALUES ('Vila São Francisco',16);
INSERT INTO district (name,id_city) VALUES ('Vlia Cordeiro',28);
        		

/*
INSERT INTO pin (id_district, name, lat, lng, address, link)
SELECT d.id AS id_district,
       i.nome,
       CAST(RPAD(REPLACE(MID(i.pin, 1, LOCATE(',', i.pin)-1), '.', ''),10,'0') AS SIGNED) AS lat,
       CAST(RPAD(REPLACE(MID(i.pin, LOCATE(',', i.pin)+1, 100), '.', ''),10,'0') AS SIGNED) AS lng,
       i.endereco,
       i.link
  FROM importacao i
  JOIN district d ON d.name = i.bairro;
*/

INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (1,'Vila St. Gallen',-224357578,-429763469,'Rua Augusto do Amaral Peixoto, 166.','http://www.vilastgallen.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (5,'Botequim do Itahy',-229430154,-433408759,'Estrada de Jacarepaguá, 7544.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (6,'Bier Prosit Cervejas Especiais',-225011140,-440929060,'Av. Lucas Evangelista de Oliveira Franco, 1036.','http://www.bierprosit.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Barbearia Tradicional Navalha de Ouro - Rosa Shopping',-230022121,-433495592,'Av. Marechal Henrique Lott, 120. Loja 132.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Beertaste Respect Styles - Shopping Città America',-230031080,-433218300,'Av. das Américas, 700. Bloco B. Loja 117-E.','http://www.beertaste.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Beertaste Respect Styles - Casa Shopping',-229928076,-433641429,'Av. Ayrton Senna, 2150. Bloco N. Loja I.','http://www.beertaste.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Nook Bier',-229739040,-433648740,'Av. Embaixador Abelardo Bueno, 1. Loja 170.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Mr. Beer - Barra Square Shopping Center',-230012248,-433475757,'Av. Marechal Henrique Lott, 333. Bloco 02. Loja 101.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (8,'Mr. Beer - Shopping Metropolitano',-229719861,-433733368,'Av. Embaixador Abelardo Bueno, 1300.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (11,'Dream Beer - CADEG',-228947357,-432366319,'Rua  Capitão Félix, 110. Rua 13. Loja 5.','http://www.dreambeer.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Boteco Colarinho',-229493098,-431842503,'Rua Nelson Mandela, 100. Loja 127.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Lupulino',-229514700,-431826784,'Rua Professor Álvaro Rodrigues, 148. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Espaço Caverna',-229565673,-431846837,'Rua Assis Bueno, 26.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Bar Teto Solar',-229561704,-431861682,'Rua Paulo Barreto, 110A.','http://www.bartetosolar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Inverso Bar',-229542486,-431865386,'Rua Mena Barreto, 22.','http://www.inversobar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Degustare Delicatessen',-229495536,-431888560,'Rua Guilhermina Guinle, 296. Loja B.','http://www.degustareiguarias.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Comuna',-229516050,-431899710,'Rua Sorocaba, 585.','http://www.comuna.cc');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (13,'Empório Farinha Pura',-229557481,-431965727,'Rua Voluntários da Pátria, 446.','http://www.farinhapura.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (17,'Cervejaria Suingue - Norte Shopping',-228860651,-432832656,'Av. Dom Hélder Câmara, 5474. Piso S. Loja 4506.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (17,'Mr. Beer - Norte Shopping',-228872562,-432816890,'Av. Dom Hélder Câmara, 5200. Quiosque 12A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Al Farabi',-229016649,-431755786,'Rua do Rosário, 30.','http://www.alfarabi.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Jacques & Costa Barbearia e Chopp',2290862570,-431775052,'Av. Treze de Maio, 33. Loja 407.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Monte Gordo',-229109160,-431770829,'Rua Senador Dantas, 44.','www.montegordo.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Botequim do Itahy',-229087648,-431746804,'Rua Araújo Porto Alegre, 56.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Botequim do Itahy',-229059578,-431773770,'Av. Rio Branco, 156.','http://botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Il Piccolo Caffè',-229034258,-431760605,'Rua do Carmo, 50','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Adega do Pimenta',-229071241,-431820226,'Praça Tiradentes, 6.','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Taberna Bier',-229051406,-431748258,'Rua São José, 35, Loja 231','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Tabaco Café',-229059578,-431773770,'Av. Rio Branco, 156. Loja 121.','http://www.tabacocafe.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Bistrô CD Centro',-229052850,-431759560,'Rua da Quitanda, 3. Loja B.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Dufry Shopping',-229049280,-431760354,'Rua da Assembléia, 51.','http://www.dufryshopping.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Cervejaria e Restaurante Bohemia',-225069298,-431849815,'Rua Alfredo Pachá, 166.','http://www.cervejariabohemia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (22,'Dom Barcelos',-229117687,-432020042,'Rua Correia Vasques, 39.','http://dombarcelos.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (25,'Pub Escondido, CA',-229785375,-431897990,'Rua Aires Saldanha, 98 A','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (25,'Doca´s Beer',-229635654,-431765581,'Rua Belfort Roxo, 231. Loja A.','http://docasbeer.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (25,'Os Imortais Bar e Restaurante',-229644880,-431770560,'Rua Ronald de Carvalho, 147.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (25,'Brasserie Brejauvas',-229762970,-431892150,'Rua Aires de Saldanha, 13.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (26,'Assis Garrafaria',-229392918,-431961261,'Rua Cosme Velho, 174.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (27,'Mr. Beer - Shopping Nova América',-228488703,-433214195,'Av. Pastor Martin Luther King Jr, 126. Anexo Novo. Quiosque QT16.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (28,'Herr Brauer',-229330779,-431755593,'Rua Barão do Flamengo, 35.','http://www.herrbrauer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (32,'Antiga Mercearia e Bar',-229557481,-431965727,'Rua Voluntários da Pátria, 446. Loja 7.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (33,'Fina Cerva',-229051497,-431013882,'Av. Sete de Setembro, 193. Loja 103.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (33,'Empório Icaraí Delicatessen',-229020280,-431099960,'Rua Mem de Sá, 111 - Loja 1','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'Delirium Café',-229835068,-432013415,'Rua Barão da Torre, 183.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'The Ale House',-229836910,-432122732,'Rua Visconde de Pirajá, 580','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'La Carioca Cevicheria',-229821113,-432093360,'Rua Garcia D''ávila, 173. Loja A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'Bier en Cultuur',-229837195,-432071065,'Rua Maria Quitéria, 77.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (36,'Shenanigan''s Irish Pub',-229844611,-431983953,'Rua Visconde de Pirajá, 112A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (37,'Bocca Choperia',-227474684,-428620042,'Av. 22 de maio, 5243.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (39,'Cervejaria e Restaurante Noi',-229441940,-430362180,'Est. Francisco da Cruz Nunes, 1964.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (42,'Mr. Beer - Shopping Via Parque',-229825603,-433642970,'Av. Ayrton Senna, 3000. Quiosque 55.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (44,'La Carioca Cevicheria',-229618311,-432077827,'Rua Maria Angélica, 113A.','http://www.lacarioca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (44,'Gibeer',-229646938,-432200481,'Rua Lopes Quintas, 158.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (47,'Bar & Bistrô Noi',-229031507,-431052133,'Rua Ministro Otávio Kelly, 174. Loja 109.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (51,'Ocean Drive Empório',-223042718,-416969563,'Av. Atlântica, 2720. Loja 04 e 05.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Bar do Ernesto',-229149975,-431779379,'Largo da Lapa, 41.','http://www.barernesto.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Espaço Lapa Café',-229107838,-431836383,'Rua Gomes Freire, 457.','http://www.espacolapacafe.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Boteco Carioquinha',-229139324,-431826636,'Av. Gomes Freire, 822. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Il Piccolo Caffè Biergarten',-229120707,-431846757,'Rua dos Inválidos, 135.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Multifoco Bistrô',-229126624,-431839827,'Av. Mem de Sá, 126.','http://www.multifocobistro.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (53,'Boteco D.O.C.',-229385234,-431931027,'Rua das Laranjeiras, 486.','http://www.botecodoc.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (54,'Biergarten',-229303070,-431776573,'Largo do Machado, 29. Loja 202.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (55,'Brewteco',-229829489,-432256708,'Rua Dias Ferreira, 420.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (55,'Herr Pfeffer',-229808536,-432226396,'Rua Conde Bernadotte, 26. Loja D.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (55,'Jeffrey Store',-229791221,-432237876,'Rua Tubira, 8.','http://www.jeffrey.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (56,'Noi Bar & Restaurante',-227556688,-418868459,'Rua Manoel Turíbio de Farias, 110.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (63,'Cervejaria Cidade Imperial',-224970279,-432000348,'Rua Mosela, 1.341 (Módulo 01).','http://www.cidadeimperial.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (64,'Botequim Rio Antigo',-228466084,-432676718,'Rua Uranos, 1489. ','http://www.botequimrioantigo.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (65,'Mr. Beer',-224595725,-444369502,'Rua Dorival Marcondes Godoy, 500. Loja 1003.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (67,'CervejáRio',-228866332,-432892622,'Av. Dom Helder Câmara, 6001. Loja F. (BRSTORES)','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'Botto Bar',-229128069,-432138515,'Rua Barão de Iguatemi, 205','http://www.bottobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'Achonchego Carioca',-229135322,-432151601,'Rua Barão de Iguatemi, 379','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'Bar da frente',-229134598,-432152143,'Rua Barão de Iguatemi, 388','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'Tempero da Praça',-229136925,-432153767,'Rua Barão de Iguatemi, 408','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (69,'The Hellish Pub',-229130730,-432144507,'Rua Barão de Iguatemi 292','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (70,'CineBotequim',-228987320,-431787223,'Rua Conselheiro Saraiva, 39','http://www.cinebotequim.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (73,'Itahy Premium Beer',-230114758,-434431061,'Av. Alfredo Balthazar da Silveira 520 Loja 101.','http://www.botequimdoitahyrj.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (73,'Mr. Beer - Américas Shopping',-230125846,-434621768,'Av. Das Américas, 15500. Quiosque 5.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (73,'Mr. Beer - Shopping Rio Design Barra',-230014255,-433859007,'Av. Das Américas, 7777. Loja 332A.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (79,'Adega do Pimenta',-229206595,-431848158,'Rua Almirante Alexandrino, 296','http://www.adegadopimenta.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (79,'Cafecito',-229213317,-431864306,'Rua Paschoal Carlos Magno, 121.','http://www.cafecito.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (83,'Bar do Omar',-229031015,-432042328,'Rua Sara, 114. Loja 1.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (83,'Balkonn Distribuidora',-229445605,-432876845,'Rua Pedro Alves, 240.','http://www.balkonnsab.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (84,'Restaurante Noi',-229173193,-430944630,'Av. Quintino Bocaiúva, 159.','http://www.cervejarianoi.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (84,'La Bière Pub',-229180957,-430944680,'Av. Quintino Bocaiúva, 325. Loja 117.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (88,'Beer e Bier Cafe',-229195232,-434004941,'Estrada do Rio Grande, 3486.','www.beerebier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Hopfen Cervejas Especiais',-229130847,-432271578,'Av. Maracanã, 727 - Loja H.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Bento',-229185977,-432358697,'Rua Almirante João Cândido Brasil, 134. Loja A','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Cerveja Social Clube',-229198559,-432310939,'Rua Barão de Mesquita, 141. Loja C.','http://www.cervejasocialclube.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Benditho',-229222922,-432375015,'Rua Baltazar Lisboa, 47. ','http://www.bendithobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Yeasteria',-229186740,-432393124,'Rua Pereira Nunes, 266','http://yeasteria.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Confeitaria Rita de Cássia',-229227185,-432222221,'Rua Conde de Bonfim, 28.','http://www.confeitariaritadecassia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Bobinot – Café e Bistrô',-229315193,-432386543,'Rua Conde de Bonfim, 615. Loja A.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Delicatessen Carioca',-229291947,-432432641,'Rua  Uruguai, 280.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Malte & Cia',-229258466,-432449104,'Rua Barão de Mesquita, 663. Loja 19.','https://www.malteecia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Delicatessen Nygri',-229321703,-432412633,'Rua. Uruguai, 380.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Lupulus',-229236359,-432295372,'Rua Conde de Bonfim, 255. Q5.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (89,'Mr. Beer - Shopping Tijuca',-229148030,-432287204,'Av. Maracanã, 987. Quiosque 205.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (90,'Confraria Cervejas Especiais',-228903646,-432857287,'Rua  Dr. Ferrari, 115.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (3,'Empório Alto dos Pinheiros',-235599960,-466995210,'Rua Vupabussu, 305','www.eapsp.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (3,'Melograno',-235575060,-466897000,'Rua Aspicuelta, 436','www.melograno.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (30,'FrangÓ',-235011300,-466985820,'Lg. da Matriz da N. S. do Ó, 168','frangobar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (3,'Empório Sagarana',-235567720,-466880860,'Rua Aspicuelta, 271','www.emporiosagarana.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'Asterix',-235667300,-466513840,'Alameda Joaquim Eugênio de Lima, 575','www.barasterix.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (14,'Tortula',-236216550,-466839033,'Av. Santo Amaro, 4.371','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'Arturito',-235599440,-466775800,'Rua Artur de Azevedo, 542','www.arturito.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (20,'Casa da Cerveja',-235598589,-466794573,'Rua Lisboa, 502','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (96,'Mocotó',-234866910,-465816710,'Av. Nossa Senhora do Loreto, 1.100','www.mocoto.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (61,'1ª Cervejaria da Móoca',-235625395,-465934263,'Rua Guaimbê, 148','www.primeiracervejariadamooca.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (52,'Bezerra',-235259206,-466930085,'Rua Coriolano, 800','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (77,'Rota do Acarajé',-235413150,-466542340,'Rua Martim Francisco, 529','www.rotadoacaraje.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (21,'Laus Beer Loja',-236342026,-466987950,'Rua Fernandes Moreira, 384','www.santebar.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (62,'Market Place - Laus Beer Quiosque',-236214183,-466990400,'Av. Dr. Chucri Zaidan, 902','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (15,'Cervejaria Ô Fiô',-235859175,-467182421,'Rua Lício Marcondes do Amaral, 51','cervejariaofio.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (24,'Cervejaria Devassa - Bela Cintra',-235596421,-466652694,'Rua Bela Cintra, 1.579','http://www.cervejariadevassa.com.br/index.php/unidades/bela-cintra');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (38,'Vino!',2358335430,-466742433,'Rua Professor Tamandaré de Toledo, 51','www.lojavino.com.br/lojas/sp');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (102,'Empório Bierboxx',-236168698,-466935288,'Rua Miguel Sutil, 358','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Pier 1327',-229104649,-431775862,'Rua Joaquim Távora, 1327','www.pier1327.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (35,'Belgian Beer Paradise',-236048701,-466668117,'Av. Ibijaú, 196','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'All Black',-235676801,-466639265,'Rua Oscar Freire, 163','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (98,'Kia Ora Pub',-235888795,-466754004,'Rua Doutor Eduardo de Souza Aranha, 377','www.kiaora.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (94,'Villa Grano',-235564793,-466916484,'Rua Wizard, 500','www.villagrano.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Bar Brejas',-229022611,-470517233,'Rua Conceição, 860','barbrejas.com');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (48,'Empório Biergarten',-212150430,-478237330,'Av. Lygia Latuf Salomão, 605, Mercadão da Cidade - Box 83','www.emporiobiergarten.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (2,'Cervejarium',-212024589,-478191849,'Av. Independência, 3.242','www.coloradocervejarium.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (66,'Cervejaria Bamberg',-235688745,-474594633,'Rua Sebastião Benedito Reis, 582','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (46,'Cervejaria Baden Baden',-227189827,-455672935,'Rua Dr. Djalma Forjaz, 93','www.obadenbaden.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'Karavelle Brew Pub',-235621875,-466677149,'Alameda Lorena, 1784','http://www.karavelle.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (99,'Rock Fella Burgers & Beers',-235937302,-466847490,'Rua Rócio, 89','http://www.facebook.com/RockFellaBurgersBeers');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'Delirium Café',-235629091,-466979761,'Rua Ferreira de Araújo, 589','http://www.deliriumcafesp.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'BrewDog Bar',-235613710,-466938860,'Rua dos Coropés, 41','https://www.facebook.com/brewdogsaopaulo/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'Bar Cervejaria Nacional',-235647513,-466906795,'Avenida Pedroso de Morais, 604','http://www.cervejarianacional.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (80,'Empório Laura Aguiar',-235020543,-466206711,'Rua Gabriel Piza, 559','http://emporiolauraaguiar.blogspot.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (68,'Beer Legends - Bar e Cervejaria',-235583013,-466912465,'Rua Mourato Coelho, 1112','http://www.beerlegends.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (22,'Mundo Beer',-230857788,-472070974,'Avenida Itororó, 681','https://www.facebook.com/mundobeerindaiatuba');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (91,'Cervejaria Invicta',-211749397,-478308255,'Avenida do Café, 1365','https://www.facebook.com/CervejariaInvictaBar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (23,'Bendito Malte',-230766151,-472011695,'Av. Conceição, 1950','https://www.facebook.com/benditomalte');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Kingsford Pub',-234966011,-474652980,'Av. Dr. Afonso Vergueiro, 1479','https://www.facebook.com/kingsfordpub');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (46,'Fräulein Bierhaus',-227186348,-455659832,'Rua Isola Orsi, 33','http://www.fraulein.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (34,'Leão da Terra',-234870913,-466431909,'Av. Engenheiro Caetano Álvares, 4666','http://www.leaodaterra.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (38,'Coisa Boa',-235820576,-466791951,'Rua Pedroso Alvarenga, 909','https://www.facebook.com/coisaboabar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (9,'Titus Bar',-235595511,-466497111,'Rua Rocha, 370','http://www.titusbar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (78,'Spader Bar',-212003865,-478007364,'Rua Humaita, 80','https://www.facebook.com/spaderbar');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (92,'The Joy',-235459309,-466513094,'Rua Maria Antônia, 330','http://www.thejoy.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (97,'Confrades Bier Shop',-232757647,-472907782,'Av. Prudente de Moraes, 210','http://cervejariaconfrades.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (94,'BierBoxx',-235596735,-466889514,'Rua Fradique Coutinho,842','http://barbierboxx.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (93,'Pay Per Beer',-229099573,-431771964,'Rua Professor Herbert Baldus, 125','http://www.payperbeer.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Butréco Butiquim',-208012296,-493859379,'Rua Pedro Amaral, 1822','https://www.facebook.com/butreco.butiquim');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (61,'A Boa Cerveja',-235574631,-465959488,'Rua Capitães Mores, 414','http://www.aboacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Beer Bamboo',-229099573,-431771964,'Rua Joaquim Távora, 895','http://www.beerbamboo.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (100,'Cerveja Gourmet',-235279860,-466953940,'Rua Tito 400','http://cervejagourmet.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (43,'Asgard Pub',-236547010,-465359381,'Rua das Bandeiras, 421','http://www.asgardpub.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (60,'Bier Bär',-235994804,-466680727,'Rua Tuim, 253','http://www.bierbar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (45,'Einbier Cervejas Especiais',-236881232,-465630193,'Rua Antártico, 328-C','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (95,'Pier 1327',-235876716,-466450863,'Rua Joaquim Távora, 1327','http://www.pier1327.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (50,'Bar Vila Dionísio Ribeirão Preto',-211873797,-478111445,'Rua Eliseu Guilherme, 567','http://www.viladionisio.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'Bar Asterix',-235666817,-466513688,'Alameda Joaquim Eugênio de Lima, 573','http://www.barasterix.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Nosso Bar',-229057150,-470579820,'Rua Barão de Jaguara, 988, Box 02','http://nossobarcervejasespeciais.blogspot.com.br');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (59,'Don Corleone Bar e Petiscaria',-236728586,-464601327,'Av. Dom José Gaspar, 458','http://doncorleonebar.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (49,'Aconchego Carioca',-235609132,-466606662,'Alameda Jaú, 1.372','http://www.facebook.com/aconchegocariocasp');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (2,'Cervejarium',-212024589,-478191849,'Av. Independência, 3242','http://www.cervejarium.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (82,'Tchê Café',-236308411,-466685691,'Av. Washington Luis, 5628','http://www.tchecafe.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (65,'Adega Tutóia',-235742462,-466519641,'Rua Tutóia, 260.','http://www.adegatutoia.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (12,'Velharia Pub Bar',-232865200,-476724590,'Rua Angelo Ribeiro, 274.','http://www.velhariapub.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (18,'Empório Veredas',-196498620,-439066450,'Rua Alberto Alves de Azevedo, 107.','http://www.emporioveredas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (84,'Cervejaria Wäls',-198796830,-439625140,'Rua Padre Leopoldo Mertens, 1460.','http://www.wals.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Bendicto Gole Cervejas Especiais',-221200260,-450477880,'Rua Senador Câmara, 144.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (57,'Reduto da Cerveja',-199294995,-439443947,'Av. Álvares Cabral, 1030.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (4,'Reduto da Cerveja',-199446445,-439304620,'Rua Pium-í, 570.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (58,'Reduto da Cerveja (Shopping Woods)',-199474277,-439552047,'Rua Guaicuí, 660.','http://www.redutodacerveja.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (31,'Café Viena Beer',-199291230,-439218920,'Av. do Contorno, 3968.','http://www.cafeviena.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (29,'Mamãe Bebidas',-199223603,-439357673,'Av. do Contorno, 1955.','http://mamaebebidas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (76,'Nórdico - Chopp Delivery e Cervejas Especiais',-198427190,-439741330,'Av. Deputado Anuar Menhem, 35.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (81,'Sousplat Restaurante & Sushibar',-199075361,-439421401,'Rua Rodrigues Caldas, 186.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (58,'Artesanato da Cerveja (Shopping Woods)',-199474277,-439552047,'Rua Guaicuí, 660.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (85,'Espetinho da Esquina',-199267646,-439440378,'Rua Antônio de Albuquerque, 127.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (71,'Rima dos Sabores',-199267646,-439440378,'Rua Esmeraldas, 522.','http://www.rimadossabores.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (16,'Empório Giardino',-198804650,-440415910,'Alameda dos Sabiás, 393.','http://www.emporiogiardino.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (74,'BH Cervejas',-199152887,-439552998,'Rua Conselheiro Lafaiete, 510. Loja 04.','http://www.bhcervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Restaurante e Pizzaria Edelweiss',-269997650,-514147900,'Rua Dr. Gaspar Coutinho, 439.','http://www.bierbaum.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (40,'Cervejaria Bierland',-268049131,-490878846,'Rua Gustavo Zimmermann, 5361.','http://www.bierland.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (7,'Bier Vila Choperia',-269158440,-490853420,'Rua Alberto Stein, 199 (Vila Germânica).','https://biervila.wordpress.com/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (7,'Choperia Alemão Batata',-269158440,-490853420,'Rua Alberto Stein, 199 (Vila Germânica).','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (10,'Das Bier Choperia',-268192450,-490249870,'Rua Bonifácio Haendchen, 5311.','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (75,'Estação Eisenbahn',-268932350,-491263836,'Rua Bahia, 5181.','http://www.eisenbahn.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (41,'Das Bier Kneipe',-268866340,-490685580,'Via Expressa Paul Fritz Kuehnrich, 1600 (Shopping Park Europeu).','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (19,'Das Bier Litoral',-269993632,-486304421,'Rua 2950, 426.','http://www.dasbier.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (7,'Estação Vila Bar',-269158440,-490853420,'Rua Alberto Stein, 199 (Vila Germânica).','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (72,'Mr. Beer',-202964650,-402919180,'Rua Joaquim Lírio, 610. Loja 2.','http://mrbeercervejas.com.br/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (101,'Hops Bar',-166852630,-492613130,'Rua 10, 181. Galeria 10.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (87,'Belgian Dash',-166928930,-492640116,'Rua 91, 184.','http://www.cervejasespeciais.com.br/site/');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (86,'Rash Bier',-166928930,-492640116,'Avenida T-003.','');
INSERT INTO pin (id_district,name,lat,lng,address,link) VALUES (86,'Olut',-166928930,-492640116,'Avenida T-4, 466.','http://www.olut.com.br/');

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

INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2126421575,'pin',1);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2433467612,'pin',3);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2132815339,'pin',7);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,21995103815,'pin',8);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2130959239,'pin',9);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2137963435,'pin',15);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125276909,'pin',16);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2130290789,'pin',17);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2132398000,'pin',18);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,21995416922,'pin',20);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2141096301,'pin',28);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122202156,'pin',29);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125245338,'pin',30);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,8007238379,'pin',31);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125129919,'pin',32);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125229800,'pin',34);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2131178082,'pin',35);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2135638959,'pin',36);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125488964,'pin',37);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122053598,'pin',38);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2135460945,'pin',39);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2127146348,'pin',42);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2126107175,'pin',43);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122675860,'pin',48);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2126353554,'pin',49);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2127093939,'pin',50);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,21979625442,'pin',51);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2137412945,'pin',54);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2227571336,'pin',55);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122223034,'pin',60);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122740000,'pin',65);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2422204800,'pin',67);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2138676124,'pin',68);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,24998137323,'pin',69);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2135471999,'pin',70);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2134967407,'pin',71);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,21995103815,'pin',78);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,21995103815,'pin',79);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2140636210,'pin',83);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2126110619,'pin',84);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2127107390,'pin',85);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2135793003,'pin',91);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122641517,'pin',92);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2121430077,'pin',93);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2125713497,'pin',94);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2132385832,'pin',95);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122686896,'pin',96);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2132282720,'pin',97);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2122010446,'pin',98);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130314328,'pin',100);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130312921,'pin',101);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1139324818,'pin',102);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130310816,'pin',103);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1133685610,'pin',104);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130634951,'pin',106);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1129513056,'pin',108);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1126045275,'pin',109);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1138624646,'pin',110);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1136686222,'pin',111);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1135670569,'pin',112);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1137216636,'pin',114);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130816081,'pin',115);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130786442,'pin',116);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1155396213,'pin',118);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1155396213,'pin',155);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130453597,'pin',121);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1138132725,'pin',122);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1932517912,'pin',123);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1632370722,'pin',124);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1639114949,'pin',125);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1236636082,'pin',127);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1124952225,'pin',130);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130324007,'pin',131);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1136285000,'pin',132);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1129770471,'pin',133);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1129259422,'pin',134);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1933295735,'pin',135);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1638781020,'pin',136);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1533461064,'pin',138);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1236631529,'pin',139);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1136249056,'pin',140);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130730773,'pin',141);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1133845595,'pin',142);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1631015410,'pin',143);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1136280691,'pin',144);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,11967741215,'pin',145);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1138050151,'pin',146);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1135424730,'pin',147);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1732343141,'pin',148);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1126150512,'pin',149);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1138951565,'pin',150);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1136750761,'pin',151);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1149026035,'pin',152);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1150516695,'pin',153);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1143174008,'pin',154);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1155396213,'pin',118);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1155396213,'pin',155);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1636107416,'pin',156);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1133685610,'pin',157);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1932339498,'pin',158);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1134201966,'pin',159);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1130628262,'pin',160);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1639114949,'pin',161);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1150317537,'pin',162);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,1138844343,'pin',163);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,15998347201,'pin',164);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3132438824,'pin',165);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3134432811,'pin',166);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3533314806,'pin',167);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125151770,'pin',168);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3133177974,'pin',169);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125119680,'pin',170);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3132219555,'pin',171);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3132139494,'pin',172);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125730239,'pin',173);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125164181,'pin',174);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125310660,'pin',175);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (2,3199541088,'pin',176);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3132437120,'pin',177);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3133969584,'pin',178);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,3125101377,'pin',179);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4935370531,'pin',180);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733373100,'pin',181);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733290808,'pin',182);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733294242,'pin',183);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733978600,'pin',184);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4734887371,'pin',185);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733977519,'pin',186);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733633030,'pin',187);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,4733292121,'pin',188);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,2733171446,'pin',189);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,6236365082,'pin',190);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,6232186792,'pin',191);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,6230864928,'pin',192);
INSERT INTO phone (id_phone_type,number,entity,id_entity) VALUES (1,6239201316,'pin',193);
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