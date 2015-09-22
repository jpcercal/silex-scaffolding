<?php

namespace App\Controller\Api;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        return new JsonResponse([
            'data' => 'data'
        ]);
    }
}
