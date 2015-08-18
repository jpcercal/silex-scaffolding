<?php

namespace Cekurte\Silex\Provider;

use Cekurte\Silex\Controller\Api\DefaultController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class DefaultControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['default.controller'] = $app->share(function() use ($app) {
            return new DefaultController();
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/', "default.controller:indexAction");

        return $controllers;
    }
}
