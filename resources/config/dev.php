<?php
require __DIR__ . '/prod.php';
$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;
$app['db'] = array(
    'driver'   => 'pdo_pgsql',
    'dbname'   => getenv('db_name'),
    'host'     => getenv('db_host'),
    'user'     => getenv('db_user'),
    'password' => getenv('db_password'),
    'charset' => 'UTF8'
);