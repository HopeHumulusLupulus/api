<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = 'v' . VERSION;
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
$app['telegram_bot_token'] = getenv('TELEGRAM_BOT_TOKEN');
$app['swiftmailer.options'] = array(
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'username',
    'password' => 'password',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);
$app['swiftmailer.use_spool'] = false;
$app['locale_fallbacks'] = array('en_US');
$app['translator.domains'] = [
    'messages' => [
        'pt_BR' =>[
            'Invalid Access Token' => 'Chave de acesso inválida',
            'This pin does not exist' => 'Este pin não existe',
            'Only is possible make a checkin in day' => 'Só é possvel fazer um checkin no dia',
            'Invalid user' => 'Usuário inválido',
            'Invalid token' => 'Chave inválida',
            'Invalid user or password' => 'Usuário ou senha inválida',
            "Hello, your token is: %token%\n inform in app" =>
                "Olá, seu token é: %token%\n informe no aplicativo",
            'Location dont return a complete address (country, state, city, district)' =>
                'Localização não retornou um endereço completo com país, estado, cidade e bairro',
            'Phone or email is necessary for create account' =>
                'Telefone ou email é necessário para criar uma conta',
            'Phone already used' => 'Telefone já utilizado',
            'Email already used' => 'Email já utilizado',
            'Invalid gender' => 'Sexo inválido',
            'Invalid language' => 'Idioma inválido',
            'Invalid birth' => 'Data de nascimento inválida',
            'Only allowed to 18 years' => 'Permitido apenas para maiores de 18 anos',
            'Password must be a string' => 'Senha precisa ser textual',
            'Password is not allowed under 6 characters' =>
                'Não são permidas senhas com menos de 6 caracteres'
        ]
    ]
];