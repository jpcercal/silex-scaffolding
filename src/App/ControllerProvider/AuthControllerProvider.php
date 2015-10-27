<?php

namespace App\ControllerProvider;

use App\Controller\Auth\LoginController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class AuthControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['auth.login.controller'] = $app->share(function () use ($app) {
            return new LoginController($app);
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/login', 'auth.login.controller:loginAction')->bind('auth.login');

        return $controllers;
    }
}
