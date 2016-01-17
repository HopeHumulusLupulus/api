<?php

namespace App;

use Silex\Application;
use Silex\Route;

class RoutesLoader extends Route
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();

    }

    private function instantiateControllers()
    {
        $this->app['doc.controller'] = $this->app->share(function () {
            return new Controllers\DocController();
        });
        $this->app['pins.controller'] = $this->app->share(function () {
            $pins = new Controllers\PinsController();
            $pins->app = $this->app;
            return $pins;
        });
        $this->app['user.controller'] = $this->app->share(function () {
            $user = new Controllers\UserController();
            $user->app = $this->app;
            return $user;
        });
        $this->app['state.controller'] = $this->app->share(function () {
            $state = new Controllers\StateController();
            $state->app = $this->app;
            return $state;
        });
        $this->app['about.controller'] = $this->app->share(function () {
            $state = new Controllers\AboutController();
            $state->app = $this->app;
            return $state;
        });
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];

        $api->get('/doc', "doc.controller:get");

        # pins
        $api->get('/pins', "pins.controller:getAll");
        $api->get('/pins/list', "pins.controller:listPins");
        $api->get('/pin/{id}', "pins.controller:getOne");
        $api->post('/pin', "pins.controller:save");
        $api->put('/pin/{id}', "pins.controller:update");
        $api->delete('/pin/{id}', "pins.controller:delete");
        $api->post('/pin/ranking/{id}', "pins.controller:ranking");
        $api->post('/pin/checkin/{id_pin}', "pins.controller:checkin");
        # user
        $api->get('/user/{args}', "user.controller:get")
            ->assert('args', '^(email|phone):.*')
            ->convert('args', function ($args) {
                $args = explode('/', $args);
                $return = array();
                foreach ($args as $value) {
                    $value = explode(':', $value);
                    $return[$value[0]] = $value[1];
                }
                return $return;
            });
        $api->post('/user', "user.controller:save");
        $api->put('/user', "user.controller:update");
        $api->delete('/user', "user.controller:delete");
        $api->get('/user/list', "user.controller:listUsers");
        $api->post('/user/login/email-token', 'user.controller:login_email_token');
        $api->post('/user/login/email-token/{token}', 'user.controller:login_token_confirm');
        $api->post('/user/login/password', 'user.controller:login_password');
        $api->get('/user/me', 'user.controller:me');

        $api->get('/state', "state.controller:getAll");

        $api->post('/contact', "user.controller:contact")
            ->value('to', $this->app['email_contact'])
            ->value('token', $this->app['telegram_bot.token']);

        $api->get('/about', 'about.controller:about');

        $this->app->mount('/'.$this->app["api.version"], $api);
    }
}

