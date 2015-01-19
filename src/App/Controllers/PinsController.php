<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PinsController
{

    protected $pinsService;

    public function __construct($service)
    {
        $this->pinsService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->pinsService->getAll());
    }

    public function save(Request $request)
    {
        $note = $this->getDataFromRequest($request);
        return new JsonResponse(array("id" => $this->pinsService->save($note)));
    }

    public function update($id, Request $request)
    {
        $note = $this->getDataFromRequest($request);
        $this->pinsService->update($id, $note);
        return new JsonResponse($note);
    }

    public function delete($id)
    {
        return new JsonResponse($this->pinsService->delete($id));
    }

    public function getDataFromRequest(Request $request)
    {
        return $note = array(
            "note" => $request->request->get("note")
        );
    }
}
