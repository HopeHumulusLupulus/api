<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class GlobalController {
    protected function getUser(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if(!$authorizationHeader) {
            throw new \Exception('UNDEFINED_ACCESS_TOKEN');
        }
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

    protected function getPaginatorMetadata(Request $request, $total, $per_page = 20)
    {
        $return['meta'] = [
            'pagination' => [
                'total' => $total,
                'per_page' => $per_page,
                'current_page' => (int)$request->get('page'),
                'last_page' => floor($total / $per_page),
                'from' => ($per_page * (int)$request->get('page'))?:1,
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