<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = 'v' . (defined('VERSION') ? VERSION : '0');
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
$app['telegram_bot.token'] = getenv('TELEGRAM_BOT_TOKEN');
$app['telegram_bot.log_chat'] = getenv('TELEGRAM_BOT_LOG_CHAT');
$app['telegram_bot.contact_chat'] = getenv('TELEGRAM_BOT_CONTACT_CHAT');
$app['telegram_bot.log_chat.enable'] = $app['log.level'] == Monolog\Logger::DEBUG;
$app['cli.sendmessage'] = __DIR__.'/../../src/cli.php sendmsg ';
$app['swiftmailer.options'] = array(
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'username',
    'password' => 'password',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);
$app['swiftmailer.use_spool'] = false;
$app['locale_fallbacks'] = array('en', 'pt_BR');
$app['translator.domains'] = [
    'messages' => [
        'en' => [
            'INVALID_ACCESS_TOKEN'   => 'Invalid Access Token',
            'UNDEFINED_ACCESS_TOKEN' => 'Undefined Access Token',
            'INVALID_PIN'            => 'This pin does not exist',
            'EXCEEDED_CHECKIN_LIMIT' => 'Only is possible make a checkin in day',
            'INVALID_USER'           => 'Invalid user',
            'INVALID_TOKEN'          => 'Invalid token',
            'USER_PASS_AUTH_FAIL'    => 'Invalid user or password',
            'YOUR_TOKEN'             => "Hello, your token is: %token%\n inform in app",
            'INVALID_LOCATION'       => 'Location dont return a complete address (country, state, city, district)',
            'PHONE_OR_MAIL_REQUIRED' => 'Phone or email is necessary for create account',
            'PHONE_USED'             => 'Phone already used',
            'EMAIL_USED'             => 'Email already used',
            'INVALID_GENDER'         => 'Invalid gender',
            'INVALID_LANG'           => 'Invalid language',
            'INVALID_BIRTH'          => 'Invalid birth',
            'ONLY_MORE_18Y'          => 'Only allowed to 18 years',
            'PASS_NOT_STRING'        => 'Password must be a string',
            'LOW_PASSWORD'           => 'Password is not allowed under 6 characters',
            'INVALID_VERSION'        => 'Upgrade app to new version',
            'ABOUT_TITLE'            => 'Title',
            'ABOUT_BODY'             => 'Body',
            'ABOUT_FOOTER'           => 'Footer'
        ],
        'pt_BR' =>[
            'INVALID_ACCESS_TOKEN'   => 'Chave de acesso inválida',
            'UNDEFINED_ACCESS_TOKEN' => 'Chave de acesso não definida',
            'INVALID_PIN'            => 'Este pin não existe',
            'EXCEEDED_CHECKIN_LIMIT' => 'Só é possvel fazer um checkin no dia',
            'INVALID_USER'           => 'Usuário inválido',
            'INVALID_TOKEN'          => 'Chave inválida',
            'USER_PASS_AUTH_FAIL'    => 'Usuário ou senha inválida',
            'YOUR_TOKEN'             => "Olá, seu token é: %token%\n informe no aplicativo",
            'INVALID_LOCATION'       => 'Localização não retornou um endereço completo com país, estado, cidade e bairro',
            'PHONE_OR_MAIL_REQUIRED' => 'Telefone ou email é necessário para criar uma conta',
            'PHONE_USED'             => 'Telefone já utilizado',
            'EMAIL_USED'             => 'Email já utilizado',
            'INVALID_GENDER'         => 'Sexo inválido',
            'INVALID_LANG'           => 'Idioma inválido',
            'INVALID_BIRTH'          => 'Data de nascimento inválida',
            'ONLY_MORE_18Y'          => 'Permitido apenas para maiores de 18 anos',
            'PASS_NOT_STRING'        => 'Senha precisa ser textual',
            'LOW_PASSWORD'           => 'Não são permidas senhas com menos de 6 caracteres',
            'INVALID_VERSION'        => 'Atualize para uma nova versão',
            'ABOUT_TITLE'            => 'Título',
            'ABOUT_BODY'             => 'Corpo',
            'ABOUT_FOOTER'           => 'Rodapé'
        ]
    ]
];