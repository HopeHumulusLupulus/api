<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;


class PinsController extends GlobalController
{
    public function getAll(Request $request)
    {
        return new JsonResponse($this->app['pins.service']->getAll([
            'latLng' => [
                'minLat' => $request->get('minLat'),
                'minLng' => $request->get('minLng'),
                'maxLat' => $request->get('maxLat'),
                'maxLng' => $request->get('maxLng')
            ]
        ]));
    }

    public function getOne(Request $request)
    {
        return new JsonResponse($this->app['pins.service']->getOne(
            $request->get('id')
        ));
    }

    public function listPins(Request $request)
    {
        try {
            $user = $this->getUser($request);
            $filters = array();
            if($request->get('minLat')) {
                $filters['latLng'] = [
                    'minLat' => $request->get('minLat'),
                    'minLng' => $request->get('minLng'),
                    'maxLat' => $request->get('maxLat'),
                    'maxLng' => $request->get('maxLng')
                ];
            }
            if($request->get('name')) {
                $filters['name'] = $request->get('name');
            }
            $return['data'] = $this->app['pins.service']->getAll(
                $filters,
                $request->get('page') * $this->app['pins.per_page']
            );
            $return['meta'] = parent::getPaginatorMetadata($request);
            return new JsonResponse($return);
        } catch (\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function save(Request $request)
    {
        try {
            $user = $this->getUser($request);
            $post = json_decode($request->getContent(), true);
            $post['created_by'] = $user['id'];

            if(\is_numeric($response = $this->app['pins.service']->save($post))) {
                $pin = $this->app['pins.service']->getLastInsetPin();
                $telegram = new Api($this->app['telegram_bot.token']);
                $telegram->sendMessage([
                    'chat_id' => $this->app['telegram_bot.log_chat'],
                    'text' => '```'.print_r($pin, true).'```',
                    'disable_web_page_preview' => true,
                    'parse_mode' => 'markdown'
                ]);
                return new JsonResponse(array("id" => $response));
            } else {
                throw new \Exception($response);
            }
        } catch (\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function update($id, Request $request)
    {
        try {
            $user = $this->getUser($request);
            $post = json_decode($request->getContent(), true);
            if(($enabled = $request->get('enable')) !== null) {
                unset($post['enable']);
                if($enabled) {
                    $post['enabled_by'] = $user['id'];
                } else {
                    $post['enabled_by'] = null;
                }
            }
            return new JsonResponse(array(
                "id" => $this->app['pins.service']->update(
                    $request->get('id'),
                    $post
                )
            ));
        } catch(\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $user = $this->getUser($request);
            return new JsonResponse($this->app['pins.service']->delete($id));
        } catch(\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function ranking($id, Request $request)
    {
        try {
            $user = $this->getUser($request);
            $post = json_decode($request->getContent(), true);
            foreach($post['ranking'] as $ranking) {
                $this->app['pins.service']->saveRanking(
                    $id,
                    $user['id'],
                    $ranking['code'],
                    $ranking['ranking']
                );
            }
            return new JsonResponse($this->app['pins.service']->getRanking($id));
        } catch(\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function checkin($id_pin, Request $request)
    {
        try {
            $user = $this->getUser($request);
            $post = json_decode($request->getContent(), true);
            if(!$this->app['pins.service']->getOne($id_pin)) {
                throw new \Exception('INVALID_PIN');
            }
            $last = $this->app['pins.service']->getLastCheckin($id_pin, $user['id']);
            if($last) {
                $last_created = new \DateTime();
                $last_created->sub(new \DateInterval('P1D'));
                if($last['created'] > $last_created->format('Y-m-d H-i-s')) {
                    throw new \Exception('EXCEEDED_CHECKIN_LIMIT');
                }
            }
            $this->app['pins.service']->saveCheckin(
                $id_pin,
                $user['id']
            );
            return new JsonResponse(true);
        } catch(\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }
}
