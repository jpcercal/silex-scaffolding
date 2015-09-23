<?php

use App\Provider\ApiControllerProvider;
use App\Provider\PageControllerProvider;
use App\ServiceProvider\DoctrineExtensionsServiceProvider;
use App\ServiceProvider\TranslationLoaderFilesServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$app['debug'] = Helpers::getEnv('APP_DEBUG');

Request::enableHttpMethodParameterOverride();

$doctrine = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'doctrine.php';

$app->register(new DoctrineServiceProvider(),    $doctrine['dbal']);
$app->register(new DoctrineOrmServiceProvider(), $doctrine['orm']);

$app->register(new DoctrineExtensionsServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TranslationLoaderFilesServiceProvider());

$app->register(new CorsServiceProvider(),        require CONFIG_PATH . DIRECTORY_SEPARATOR . 'cors.php');
$app->register(new MonologServiceProvider(),     require CONFIG_PATH . DIRECTORY_SEPARATOR . 'monolog.php');
$app->register(new SwiftmailerServiceProvider(), require CONFIG_PATH . DIRECTORY_SEPARATOR . 'swiftmailer.php');
$app->register(new TranslationServiceProvider(), require CONFIG_PATH . DIRECTORY_SEPARATOR . 'translation.php');
$app->register(new TwigServiceProvider(),        require CONFIG_PATH . DIRECTORY_SEPARATOR . 'twig.php');

require CONFIG_PATH . DIRECTORY_SEPARATOR . 'error.php';

$app->mount('/',    new PageControllerProvider());
$app->mount('/api', new ApiControllerProvider());

$app->after($app["cors"]);

return $app;
