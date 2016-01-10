<?php

namespace App\Services;

use Silex\Provider\DoctrineServiceProvider;
use Doctrine\DBAL\Driver\Connection;
class BaseService
{

    /**
     * @var Connection
     */
    protected $db;

    public function __construct($app)
    {
        $this->app = $app;
        $this->db = $app['db'];
    }

}
