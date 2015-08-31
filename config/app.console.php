<?php

use Kurl\Silex\Provider\DoctrineMigrationsProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Console\Application as SymfonyApplication;

$app = new Application();

$app['debug'] = true;

$console = new SymfonyApplication();

$app->register(new DoctrineMigrationsProvider($console), require CONFIG_PATH . DIRECTORY_SEPARATOR . 'migrations.php');
$app->register(new DoctrineServiceProvider(),            require CONFIG_PATH . DIRECTORY_SEPARATOR . 'doctrine.php');

return $app;
