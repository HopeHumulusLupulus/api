<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\StateService;


class StateController
{
    public function getAll(Request $request)
    {
        return new JsonResponse($this->app['state.service']->getState());
    }
}
