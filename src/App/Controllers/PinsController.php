<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;


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

    public function __construct($app)
    {
        $this->app = $app;
        $this->pinsService = $app['pins.service'];
        $this->userService = $app['user.service'];
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
        try {
            $post = json_decode($request->getContent(), true);
            if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
                return new Response('Invalid Access Token', 403);
            }
            unset($post['access-token']);
            $post['created_by'] = $user['id'];
            
            if(\is_numeric($response = $this->pinsService->save($post))) {
                return new JsonResponse(array("id" => $response));
            } else {
                return new Response($response, 403);
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 403);
        }
    }

    public function update($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        unset($post['access-token']);
        $post['enabled_by'] = $user['id'];
        return new JsonResponse(array(
            "id" => $this->pinsService->update(
                $request->get('id'),
                $post
            )
        ));
    }

    public function delete($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        unset($post['access-token']);
        return new JsonResponse($this->pinsService->delete($id));
    }

    public function ranking($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        unset($post['access-token']);
        foreach($post['ranking'] as $ranking) {
            $this->pinsService->saveRanking(
                $id,
                $user['id'],
                $ranking['code'],
                $ranking['ranking']
            );
        }
        return new JsonResponse($this->pinsService->getRanking($id));
    }

    public function checkin($id_pin, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$this->pinsService->getOne($id_pin)) {
            return new Response('This pin does not exist', 403);
        }
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        $last = $this->pinsService->getLastCheckin($id_pin, $user['id']);
        if($last) {
            $last_created = new \DateTime();
            $last_created->sub(new \DateInterval('P1D'));
            if($last['created'] > $last_created->format('Y-m-d H-i-s')) {
                return new Response('Only is possible make a checkin ', 403);
            }
        }
        $this->pinsService->saveCheckin(
            $id_pin,
            $user['id']
        );
        return new JsonResponse(true);
    }
}
