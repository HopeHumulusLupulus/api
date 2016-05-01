<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PinsService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;


class UserController
{
    /**
     * @SWG\Get(
     *     path="/user/get",
     *     @SWG\Response(response="200", description="An example resource")
     * )
     */
    public function get(Request $request, $args)
    {
        return new JsonResponse($this->app['user.service']->get($args));
    }

    public function save(Request $request)
    {
        try {
            $id = $this->app['user.service']->save(
                $user = json_decode($request->getContent(), true)
            );
            $user = $this->app['user.service']->get($user);
            if(isset($user['method']) && $user['method'] && !isset($user['password'])) {
                $method = 'login_' . $this->app['slugify']->slugify($user['method'], '_');
                $this->$method($request, $user);
            } else {
                $user['access-token'] = $this->app['user.service']->requestToken(array(
                    'id_user_account' => $id,
                    'method' => isset($user['method']) && $user['method'] ? $user['method'] : 'password',
                    'attempts' => 1,
                    'access_token' => bin2hex(openssl_random_pseudo_bytes(20)),
                    'authenticated' => date('Y-m-d H:i:s.u')
                ));
                $user['access-token'] = $user['access-token']['access_token'];
            }
            return new JsonResponse($user);
        } catch (\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function update(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        try {
            $this->app['user.service']->save($post, $user);
            return new JsonResponse(true);
        } catch(\Exception $e) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($e->getMessage()))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function delete(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->validateAccessToken($post['access-token'])) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_ACCESS_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        $this->app['user.service']->delete($user['id']);
        return new JsonResponse(true);
    }

    public function contact($to, $token, Request $request)
    {
        if(\is_numeric($response = $this->app['user.service']->contact(
            $data = json_decode($request->getContent(), true)
        ))) {
            try {
                if(function_exists('popen') && function_exists('pclose')) {
                    pclose(popen('php '.$this->app['cli.sendmessage'].
                        base64_encode(serialize([
                            'params' => [
                                'chat_id' => $this->app['telegram_bot.contact_chat'],
                                'text' => print_r($data, true)
                            ],
                            'token' => $this->app['telegram_bot.token']
                        ])).' &', 'r'
                    ));
                } else {
                    $telegram = new Api($this->app['telegram_bot.token']);
                    $telegram->sendMessage([
                        'params' => [
                            'chat_id' => $this->app['telegram_bot.contact_chat'],
                            'text' => print_r($data, true),
                        ]
                    ]);
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contato')
                    ->setFrom(array($data['email'] => $data['name']))
                    ->setTo(array($to => 'Lupulocalizador'))
                    ->setBody($data['message']);
                $result = $this->app['mailer']->send($message);
            } catch (\Exception $e) {
                if(function_exists('popen') && function_exists('pclose')) {
                    pclose(popen('php '.$this->app['cli.sendmessage'].
                        base64_encode(serialize([
                            'params' => [
                                'chat_id' => $this->app['telegram_bot.contact_chat'],
                                'text' => print_r($data, true)
                            ],
                            'token' => $this->app['telegram_bot.token']
                        ])).' &', 'r'
                    ));
                } else {
                    $telegram = new Api($this->app['telegram_bot.token']);
                    $telegram->sendMessage([
                        'params' => [
                            'chat_id' => $this->app['telegram_bot.contact_chat'],
                            'text' => print_r($e->getMessage(), true),
                        ]
                    ]);
                }
            }
            return new JsonResponse(array("protocol" => $response));
        } else {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans($response))
            )), 403, array('Content-Type' => 'application/json'));
        }
        return new JsonResponse(true);
    }

    public function login_email_token(Request $request, $user = array())
    {
        $data = json_decode($request->getContent(), true);
        if(!$user) {
            if(!$user = $this->app['user.service']->get($data)) {
                return new Response(json_encode(array(
                    'messages'=>array($this->app['translator']->trans('INVALID_USER'))
                )), 403, array('Content-Type' => 'application/json'));
            }
        }
        $token = $this->app['user.service']->requestToken([
            'id_user_account' => $user['code'],
            'method' => 'email-token'
        ]);
        $message = \Swift_Message::newInstance()
            ->setSubject('Lupulocalizador Token')
            ->setFrom(array($this->app['email_contact'] => 'Lupulocalizador'))
            ->setTo(array($data['email'] => $data['name']))
            ->setBody($this->app['translator']->trans(
                "YOUR_TOKEN",
                array('%token%' => $token['token'])
            ));
        $result = $this->app['mailer']->send($message);
        return new JsonResponse(true);
    }

    public function login_token_confirm($token, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if(!$user = $this->app['user.service']->get($data)) {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_USER'))
            )), 403, array('Content-Type' => 'application/json'));
        }
        $access_token = $this->app['user.service']->validateToken(array(
            'id' => $user['code'],
            'method' => $data['email'] ? 'email-token' : 'sms-token',
            'token' => $token
        ));
        if($access_token) {
            return new JsonResponse(array(
                'access-token' => $access_token
            ));
        } else {
            return new Response(json_encode(array(
                'messages'=>array($this->app['translator']->trans('INVALID_TOKEN'))
            )), 403, array('Content-Type' => 'application/json'));
        }
    }

    public function login_password(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if($access_token = $this->app['user.service']->loginByPassword($post)) {
            return new JsonResponse(array(
                'access-token' => $access_token
            ));
        }
        return new Response(json_encode(array(
            'messages'=>array($this->app['translator']->trans('USER_PASS_AUTH_FAIL'))
        )), 403, array('Content-Type' => 'application/json'));
    }
}
