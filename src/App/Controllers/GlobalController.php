<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class GlobalController {
    protected function getUser(Request $request)
    {
        $headers = getallheaders();
        if(!array_key_exists('Authorization', $headers)) {
            throw new \Exception('UNDEFINED_ACCESS_TOKEN');
        }
        $authorizationHeader = $headers['Authorization'];
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

    protected function getPaginatorMetadata(Request $request)
    {
        $return['meta'] = [
            'pagination' => [
                'total' => $this->app['pins.service']->getTotalRows(),
                'per_page' => $this->app['pins.per_page'],
                'current_page' => (int)$request->get('page'),
                'last_page' => floor($this->app['pins.service']->getTotalRows() / $this->app['pins.per_page']),
                'from' => ($this->app['pins.per_page'] * (int)$request->get('page'))?:1,
            ]
        ];
        $return['meta']['pagination']['to'] =
        ($return['meta']['pagination']['total'] -1 - $return['meta']['pagination']['from']) < $return['meta']['pagination']['per_page']
        ? $return['meta']['pagination']['total']
        : $return['meta']['pagination']['per_page'] * ($return['meta']['pagination']['current_page']+1);

        $queryString = $request->query->all();
        $path = $request->getPathInfo();
        $host = $request->headers->get('host');
        $scheme = $request->getScheme();
        if($return['meta']['pagination']['current_page'] >= $return['meta']['pagination']['last_page']) {
            $return['meta']['pagination']['next_page_url'] = null;
        } else {
            $queryString['page'] = $return['meta']['pagination']['current_page'] + 1;
            $return['meta']['pagination']['next_page_url'] =
            $scheme.'://'.$host.$path.'?'.http_build_query($queryString);
        }
        if($return['meta']['pagination']['current_page'] <= 0) {
            $return['meta']['pagination']['prev_page_url'] = null;
        } else {
            $queryString['page'] = $return['meta']['pagination']['current_page'] -1;
            $return['meta']['pagination']['prev_page_url'] =
            $scheme.'://'.$host.$path.'?'.http_build_query($queryString);
        }
        return $return['meta'];
    }
}