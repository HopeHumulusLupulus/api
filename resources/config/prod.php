<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = "v1";
$app['email_contact'] = getenv('EMAIL_CONTACT');
$app['db'] = array(
    'driver'   => 'pdo_pgsql',
    'dbname'   => getenv('db_name'),
    'host'     => getenv('db_host'),
    'user'     => getenv('db_user'),
    'password' => getenv('db_password'),
    'schema'   => getenv('db_schema'),
    'charset'  => 'UTF8'
);
