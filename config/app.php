<?php

require CONFIG_PATH . DIRECTORY_SEPARATOR . 'dotenv.php';
require CONFIG_PATH . DIRECTORY_SEPARATOR . 'helpers.php';

use Cekurte\Silex\Provider\ApiControllerProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$app['debug'] = Helpers::getEnv('APP_DEBUG');

Request::enableHttpMethodParameterOverride();

$app->register(new SessionServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider(), require CONFIG_PATH . DIRECTORY_SEPARATOR . 'doctrine.php');
$app->register(new MonologServiceProvider(),  require CONFIG_PATH . DIRECTORY_SEPARATOR . 'monolog.php');
$app->register(new TwigServiceProvider(),     require CONFIG_PATH . DIRECTORY_SEPARATOR . 'twig.php');

require CONFIG_PATH . DIRECTORY_SEPARATOR . 'error.php';

$app->mount('/api', new ApiControllerProvider());

return $app;
