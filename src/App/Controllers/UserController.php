<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;
use App\Services\UserService;


class UserController
{

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct($service)
    {
        $this->userService = $service;
    }

    public function get(Request $request, $args)
    {
        return new JsonResponse($this->userService->get($args));
    }

    public function save(Request $request)
    {
        if(\is_numeric($response = $this->userService->save(
            json_decode($request->getContent(), true)
        ))) {
            return new JsonResponse(array("id" => $response));
        } else {
            return new Response($response, 403);
        }
    }

    public function update($id, Request $request)
    {
        return new JsonResponse(array(
            "id" => $this->userService->update(
                $request->get('id'),
                json_decode($request->getContent(), true)
            )
        ));
    }

    public function delete($id)
    {
        return new JsonResponse($this->userService->delete($id));
    }

    public function contact($to, Request $request)
    {
        if(\is_numeric($response = $this->userService->contact(
            $to,
            json_decode($request->getContent(), true)
        ))) {
            return new JsonResponse(array("protocol" => $response));
        } else {
            return new Response($response, 403);
        }
        return new JsonResponse(true);
    }

    public function login_email_token($token)
    {
        $break = 1;
    }
}
