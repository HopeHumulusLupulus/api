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
            $user = json_decode($request->getContent(), true)
        ))) {
            $user['code'] = $response;
            if($user['method'] && !isset($user['password'])) {
                $method = 'login_' . $this->app['slugify']->slugify($user['method'], '_');
                $this->$method($request, $user);
            }
            return new JsonResponse(array("id" => $response));
        } else {
            return new Response($response, 403);
        }
    }

    public function update(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        return new JsonResponse(array(
            "id" => $this->userService->update(
                $user['id'],
                $post
            )
        ));
    }

    public function delete(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        if(!$user = $this->userService->validateAccessToken($post['access-token'])) {
            return new Response('Invalid Access Token', 403);
        }
        $this->userService->delete($user['id']);
        return new JsonResponse(true);
    }

    public function contact($to, Request $request)
    {
        if(\is_numeric($response = $this->userService->contact(
            $data = json_decode($request->getContent(), true)
        ))) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Contato')
                ->setFrom(array($data['email'] => $data['name']))
                ->setTo(array($to => 'Lupulocalizador'))
                ->setBody($data['message']);
            $result = $this->app['mailer']->send($message);
            return new JsonResponse(array("protocol" => $response));
        } else {
            return new Response($response, 403);
        }
        return new JsonResponse(true);
    }

    public function login_email_token(Request $request, $user = array())
    {
        $data = json_decode($request->getContent(), true);
        if(!$user) {
            if(!$user = $this->userService->get($data)) {
                return new Response('Invalid user', 403);
            }
        }
        $data['id'] = $user['code'];
        $data['method'] = 'email-token';
        $token = $this->userService->requestToken($data);
        $message = \Swift_Message::newInstance()
            ->setSubject('Lupulocalizador Token')
            ->setFrom(array($this->app['email_contact'] => 'Lupulocalizador'))
            ->setTo(array($data['email'] => $data['name']))
            ->setBody("Olá, seu token é: $token\n informe no aplicativo");
        $result = $this->app['mailer']->send($message);
        return new JsonResponse(true);
    }
    
    public function login_token_confirm($token, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if(!$user = $this->userService->get($data)) {
            return new Response('Invalid user', 403);
        }
        $access_token = $this->userService->validateToken(array(
            'id' => $user['code'],
            'method' => $data['email'] ? 'email-token' : 'sms-token',
            'token' => $token
        ));
        if($access_token) {
            return new JsonResponse(array(
                'access-token' => $access_token
            ));
        } else {
            return new Response('Invalid token', 403);
        }
    }
    
    public function login_password(Request $request) 
    {
        $post = json_decode($request->getContent(), true);
        if($access_token = $this->userService->loginByPassword($post)) {
            return new JsonResponse(array(
                'access-token' => $access_token
            ));
        }
        return new Response('Invalid user or password', 403);
    }
}
