<?php

namespace App\Controller\Auth;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    public function loginAction(Request $request)
    {
        $app = $this->getApp();

        return $this->render('Auth/login.twig.html', [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]);
    }
}
