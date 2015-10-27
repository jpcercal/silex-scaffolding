<?php

namespace App\ControllerProvider;

use App\Controller\Api\DefaultController;
use App\Controller\Api\UserController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['api.default.controller'] = $app->share(function () use ($app) {
            return new DefaultController($app);
        });

        $app['api.user.controller'] = $app->share(function () use ($app) {
            return new UserController($app);
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'api.default.controller:indexAction')->bind('api.default');

        $controllers
            ->get('/user', 'api.user.controller:indexAction')
            ->bind('api.user')
        ;

        $controllers
            ->get('/user/{username}', 'api.user.controller:showAction')
            ->bind('api.user.show')
        ;

        $controllers
            ->post('/user', 'api.user.controller:createAction')
            ->bind('api.user.create')
        ;

        $controllers
            ->put('/user/{username}', 'api.user.controller:updateAction')
            ->bind('api.user.update')
        ;

        $controllers
            ->delete('/user/{username}', 'api.user.controller:deleteAction')
            ->bind('api.user.delete')
        ;

        return $controllers;
    }
}
