<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;


class PinsController
{
    public function getAll(Request $request)
    {
        return new JsonResponse($this->app['pins.service']->getAll(
            $request->get('minLat'),
            $request->get('minLng'),
            $request->get('maxLat'),
            $request->get('maxLng')
        ));
    }

    public function getOne(Request $request)
    {
        return new JsonResponse($this->app['pins.service']->getOne(
            $request->get('id')
        ));
    }

    public function save(Request $request)
    {
        try {
            $post = json_decode($request->getContent(), true);
            if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
                throw new \Exception('INVALID_ACCESS_TOKEN');
            }
            unset($post['access-token']);
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
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        unset($post['access-token']);
        $post['enabled_by'] = $user['id'];
        return new JsonResponse(array(
            "id" => $this->app['pins.service']->update(
                $request->get('id'),
                $post
            )
        ));
    }

    public function delete($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        unset($post['access-token']);
        return new JsonResponse($this->app['pins.service']->delete($id));
    }

    public function ranking($id, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        unset($post['access-token']);
        foreach($post['ranking'] as $ranking) {
            $this->app['pins.service']->saveRanking(
                $id,
                $user['id'],
                $ranking['code'],
                $ranking['ranking']
            );
        }
        return new JsonResponse($this->app['pins.service']->getRanking($id));
    }

    public function checkin($id_pin, Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$this->app['pins.service']->getOne($id_pin)) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_PIN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        $last = $this->app['pins.service']->getLastCheckin($id_pin, $user['id']);
        if($last) {
            $last_created = new \DateTime();
            $last_created->sub(new \DateInterval('P1D'));
            if($last['created'] > $last_created->format('Y-m-d H-i-s')) {
                return new Response(json_encode(array(
                    'messages'=>array($this->app['translator']->trans('EXCEEDED_CHECKIN_LIMIT'))
                )), 403, array('Content-Type' => 'application/json'));
            }
        }
        $this->app['pins.service']->saveCheckin(
            $id_pin,
            $user['id']
        );
        return new JsonResponse(true);
    }
}
