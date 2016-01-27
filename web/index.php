<?php
use Silex\Application;
preg_match('/^\/v(?P<version>\d)\//', $_SERVER['REQUEST_URI'], $matches);
$abort = array();
if(!isset($matches['version'])) {
    define('VERSION', 2);
    $abort[403] = 'Invalid version';
} else if($matches['version'] < 1) {
    define('VERSION', 2);
    $abort[436] = 'INVALID_VERSION';
} else {
    define('VERSION', $matches['version']);
}
define('ROOT_PATH', dirname(dirname(dirname(__FILE__))).'/v'.VERSION);
$loader = require_once ROOT_PATH . '/vendor/autoload.php';
$loader->set('App', ROOT_PATH .'/src');
$app = new Silex\Application();
$app = require ROOT_PATH . '/src/app.php';

if($abort) {
    $app->before(function ($request) use($app, $abort) {
        $app->abort(key($abort), $app['translator']->trans(current($abort)));
    }, Application::EARLY_EVENT);
}

$app['http_cache']->run();