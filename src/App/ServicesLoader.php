<?php

namespace App;

use Silex\Application;

class ServicesLoader
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {
        $this->app['pins.service'] = $this->app->share(function () {
            return new Services\PinsService($this->app);
        });
        $this->app['user.service'] = $this->app->share(function () {
            return new Services\UserService($this->app);
        });
        $this->app['state.service'] = $this->app->share(function () {
            return new Services\StateService($this->app);
        });
    }
}

