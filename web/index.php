<?php

define('ROOT_PATH', dirname(dirname(__FILE__)));
$loader = require_once ROOT_PATH . '/vendor/autoload.php';

$app = new Silex\Application();
preg_match('/^\/v(?P<version>\d)\//', $_SERVER['REQUEST_URI'], $matches);
if(!isset($matches['version'])) {
    $app->abort('403', 'Invalid version');
}
$loader->set('App', ROOT_PATH . '/v'.$matches['version'].'/src');
require ROOT_PATH . '/v'.$matches['version'].'/src/app.php';

$app['http_cache']->run();
