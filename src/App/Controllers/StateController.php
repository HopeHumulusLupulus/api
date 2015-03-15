<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\StateService;


class StateController
{

    /**
     * @var StateService
     */
    protected $stateService;

    public function __construct($service)
    {
        $this->stateService = $service;
    }

    public function getAll(Request $request)
    {
        return new JsonResponse($this->stateService->getState());
    }
}
