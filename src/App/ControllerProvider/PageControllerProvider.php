<?php

namespace App\ControllerProvider;

use App\Controller\Page\HomeController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class PageControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['page.home.controller'] = $app->share(function () use ($app) {
            return new HomeController($app);
        });

        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'page.home.controller:indexAction')->bind('page.home');

        return $controllers;
    }
}
