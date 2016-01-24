<?php
use Phinx\Db\Adapter\AdapterFactory;
require 'vendor/autoload.php';
$dev = require 'resources/config/dev.php';
$prod = require 'resources/config/prod.php';
if($prod['db']['driver'] == 'pdo_pgsql') {
    AdapterFactory::instance()->registerAdapter('pdo_pgsql', 'PhinxFix\Db\Adapter\PdoPostgresAdapter');
}
return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'environments' => [
        'default_migration_table' => 'pinxlog',
        'default_database' => 'development',
        'production' => [
            'adapter' => $prod['db']['driver'],
            'host'    => $prod['db']['host'],
            'name'    => $prod['db']['dbname'],
            'user'    => $prod['db']['user'],
            'pass'    => $prod['db']['password'],
            'schema'  => $prod['db']['schema'],
            'charset' => $prod['db']['charset']
        ],
        'development' => [
            'adapter' => $prod['db']['driver'],
            'host'    => $dev['db']['host'],
            'name'    => $dev['db']['dbname'],
            'user'    => $dev['db']['user'],
            'pass'    => $dev['db']['password'],
            'schema'  => $dev['db']['schema'],
            'charset' => $dev['db']['charset']
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => '127.0.0.1',
            'name' => 'api_testing',
            'user' => 'postgres',
            'pass' => '',
            'schema' => 'public'
        ]
    ]
];