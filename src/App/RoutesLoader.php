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
            return new Controllers\PinsController($this->app['pins.service']);
        });
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];

        $api->get('/pins', "pins.controller:getAll");
        $api->get('/pins/{id}', "pins.controller:getOne");
        $api->post('/pins', "pins.controller:save");
        $api->put('/pins/{id}', "pins.controller:update");
        $api->delete('/pins/{id}', "pins.controller:delete");

        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"], $api);
    }
}

