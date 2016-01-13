<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class GlobalController {
    protected function getUser(Request $request)
    {
        $user = null;
        $authorizationHeader = $request->headers->get('Authorization', true);
        if(preg_match('/^Token (?P<token>.*)$/', $authorizationHeader, $matches)) {
            $user = $this->app['user.service']->validateAccessToken($matches['token']);
        } else {
            throw new \Exception('UNDEFINED_ACCESS_TOKEN');
        }
        if(!$user) {
            throw new \Exception('INVALID_ACCESS_TOKEN');
        }
        return $user;
    }
}