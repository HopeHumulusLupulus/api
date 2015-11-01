<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = 'v'.VERSION;
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
$app['swiftmailer.options'] = array(
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'username',
    'password' => 'password',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);
$app['swiftmailer.use_spool'] = false;