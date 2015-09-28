<?php

use App\Application;
use App\Provider\ApiControllerProvider;
use App\Provider\PageControllerProvider;
use Cekurte\Environment\Environment;
use Cekurte\Silex\Manager\Provider\ManagerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$app['debug'] = Environment::get('APP_DEBUG');

$app['cekurte.manager.providers'] = require CONFIG_PATH . DS . 'manager.php';

$app->register(new ManagerServiceProvider());

Request::enableHttpMethodParameterOverride();

require CONFIG_PATH . DS . 'error.php';

$app->mount('/', new PageControllerProvider());

$app->mount('/api', new ApiControllerProvider());

return $app;
