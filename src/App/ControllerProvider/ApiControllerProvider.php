<?php

namespace App\ControllerProvider;

use App\Controller\Api\DefaultController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['api.default.controller'] = $app->share(function () use ($app) {
            return new DefaultController($app);
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'api.default.controller:indexAction')->bind('api.default');

        return $controllers;
    }
}
