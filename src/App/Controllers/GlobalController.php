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
        }
        if(!$user) {
            throw new \Exception('INVALID_ACCESS_TOKEN');
        }
        return $user;
    }
}