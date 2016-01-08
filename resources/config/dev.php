<?php
require __DIR__ . '/prod.php';
$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;
$app['email_contact'] = getenv('EMAIL_CONTACT');
$app['telegram_bot.log_chat'] = getenv('TELEGRAM_BOT_LOG_CHAT_DEV');
$app['db'] = array(
    'driver'   => getenv('DB_DRIVER'),
    'host'     => getenv('DB_HOST'),
    'dbname'   => getenv('DB_NAME'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'schema'   => getenv('DB_SCHEMA'),
    'charset'  => getenv('DB_CHARSET')
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