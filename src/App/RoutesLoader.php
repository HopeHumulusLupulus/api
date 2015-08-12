<?php

namespace App;

use Silex\Application;

class RoutesLoader
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
        $this->app['pins.controller'] = $this->app->share(function () {
            return new Controllers\PinsController(
                $this->app['pins.service'],
                $this->app['user.service']
            );
        });
        $this->app['user.controller'] = $this->app->share(function () {
            return new Controllers\UserController($this->app['user.service']);
        });
        $this->app['state.controller'] = $this->app->share(function () {
            return new Controllers\StateController($this->app['state.service']);
        });
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];

        # pins
        $api->get('/pins', "pins.controller:getAll");
        $api->get('/pin/{id}', "pins.controller:getOne");
        $api->post('/pin', "pins.controller:save");
        $api->put('/pin/{id}', "pins.controller:update");
        $api->delete('/pin/{id}', "pins.controller:delete");
        $api->post('/pin/ranking/{id}', "pins.controller:ranking");
        $api->post('/pin/checkin/{id_pin}', "pins.controller:checkin");
        # user
        $api->get('/user/{args}', "user.controller:get")
            ->assert('args', '.*')
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
        $api->put('/user/{id}', "user.controller:update");
        $api->delete('/user/{id}', "user.controller:delete");

        $api->get('/state', "state.controller:getAll");

        $api->post('/contact', "user.controller:contact")
            ->value('to', $this->app['email_contact']);
        $this->app['monolog']->addError('email', $this->app['email_contact']);

        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"], $api);
    }
}

