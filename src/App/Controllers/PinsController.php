<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;
use App\Services\UserService;


class PinsController
{

    /**
     * @var PinsService
     */
    private $pinsService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct($pin_service, $user_service)
    {
        $this->pinsService = $pin_service;
        $this->userService = $user_service;
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
        if(\is_numeric($response = $this->pinsService->save(
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

    public function ranking($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        foreach($post['ranking'] as $ranking) {
            $this->pinsService->saveRanking(
                $id,
                $post['user_code'],
                $ranking['code'],
                $ranking['ranking']
            );
        }
        return new JsonResponse(true);
    }

    public function checkin($id_pin, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$this->pinsService->getOne($id_pin)) {
            return new Response('This pin does not exist', 403);
        }
        if(!$this->userService->get(array('id' => $post['user_code']))) {
            return new Response('Dont exists user with this code', 403);
        }
        $last = $this->pinsService->getLastCheckin($id_pin, $post['user_code']);
        if($last) {
            $last_created = new \DateTime();
            $last_created->sub(new \DateInterval('P1D'));
            if($last['created'] > $last_created->format('Y-m-d H-i-s')) {
                return new Response('Only is possible make a checkin ', 403);
            }
        }
        $this->pinsService->saveCheckin(
            $id_pin,
            $post['user_code']
        );
        return new JsonResponse(true);
    }
}
