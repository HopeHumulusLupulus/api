<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
class GlobalController {
    public function about()
    {
        return new JsonResponse([
            'title' => $this->app['translator']->trans('ABOUT_TITLE'),
            'body' => $this->app['translator']->trans('ABOUT_BODY'),
            'footer' => $this->app['translator']->trans('ABOUT_FOOTER')
        ]);
    }
}