<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;


class PinsController
{

    /**
     * @var PinsService
     */
    protected $pinsService;

    public function __construct($service)
    {
        $this->pinsService = $service;
    }

    public function getAll(Request $request)
    {
        return new JsonResponse($this->pinsService->getAll(
            $request->get('minLat'),
            $request->get('minLng'),
            $request->get('maxLat'),
            $request->get('maxLng')
        ));
    }

    public function getOne(Request $request)
    {
        return new JsonResponse($this->pinsService->getOne(
            $request->get('id')
        ));
    }

    public function save(Request $request)
    {
        return new JsonResponse(array("id" => $this->pinsService->save(
            json_decode($request->getContent(), true)
        )));
    }

    public function update($id, Request $request)
    {
        return new JsonResponse(array(
            "id" => $this->pinsService->update(
                $request->get('id'),
                json_decode($request->getContent(), true)
            )
        ));
    }

    public function delete($id)
    {
        return new JsonResponse($this->pinsService->delete($id));
    }
}
