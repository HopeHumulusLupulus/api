<?php

namespace App\Services;

use Silex\Provider\DoctrineServiceProvider;
class BaseService
{

    /**
     * @var DoctrineServiceProvider
     */
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

}
