<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;


class DocController
{

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function get(Request $request)
    {
        $swagger = \Swagger\scan(ROOT_PATH .'/src');
        return new JsonResponse($swagger);
    }
}
