<?php

use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;
use App\Handler\MonologTelegramHandler;

date_default_timezone_set('America/Sao_Paulo');

$env = getenv('APP_ENV') ?: 'prod';

require ROOT_PATH . '/resources/config/'.$env.'.php';

//handling CORS preflight request
$app->before(function (Request $request, $app) {
    if ($request->getMethod() === 'OPTIONS') {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin','*');
        $response->headers->set('Access-Control-Allow-Methods','GET,POST,PUT,DELETE,OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers','Content-Type,Authotization,Accept-Language');
        $response->setStatusCode(200);
        return $response;
    }
}, Application::EARLY_EVENT);

//handling CORS respons with right headers
$app->after(function (Request $request, Response $response, $app) {
    if(!$response->headers->get('Access-Control-Allow-Origin')){
        $response->headers->set('Access-Control-Allow-Origin','*');
    }
    if(!$response->headers->get('Access-Control-Allow-Methods')){
        $response->headers->set('Access-Control-Allow-Methods','GET,POST,PUT,DELETE,OPTIONS');
    }

    return $response;
});

//accepting JSON
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new ServiceControllerServiceProvider());

$app->register(new DoctrineServiceProvider(), array('db.options' => $app['db']));

if($app['db.options']['schema']) {
    $app['db']->query('SET search_path TO '.$app['db.options']['schema']);
}

$app->register(new HttpCacheServiceProvider(), array('http_cache.cache_dir' => ROOT_PATH . '/storage/cache'));

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => ROOT_PATH . '/storage/logs/' . date('Y-m-d') . '.log',
    'monolog.level' => $app['log.level'],
    'monolog.name' => 'application'
));
$app['monolog'] = $app->share($app->extend('monolog', function($monolog, $app) {
    if($app['telegram_bot.log_chat.enable'] && $app['log.level'] == Monolog\Logger::DEBUG ) {
        $monolog->pushHandler(new MonologTelegramHandler([
            'token' => $app['telegram_bot.token'],
            'chat_id' => $app['telegram_bot.log_chat'],
            'command' => $app['cli.sendmessage']
        ]));
    }
    return $monolog;
}));

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => $app['swiftmailer.options'],
    'swiftmailer.use_spool' => $app['swiftmailer.use_spool']
));

$app->register(new Cocur\Slugify\Bridge\Silex\SlugifyServiceProvider());

$request = Request::createFromGlobals();
$lang = $request->get('lang');
if($lang) {
    $app['locale'] = $lang;
}
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => $app['locale_fallbacks'],
    'translator.domains' => $app['translator.domains'],
));

//load services
$servicesLoader = new App\ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

//load routes
$routesLoader = new App\RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    $response = array(
        'statusCode' => $code,
        'message' => $e->getMessage()
    );
    if($app['debug']) {
        $response['stacktrace'] = $e->getTraceAsString();
    }
    return new JsonResponse($response);
});

return $app;