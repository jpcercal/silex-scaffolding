<?php

$doctrine = require CONFIG_PATH . DS . 'doctrine.php';

return [
    'Cekurte\Silex\Provider\EnvironmentServiceProvider' => [
        'register' => false,
    ],
    'Silex\Provider\DoctrineServiceProvider' => [
        'register' => true,
        'type'     => 'array',
        'src'      => $doctrine['dbal'],
    ],
    'Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider' => [
        'register' => true,
        'type'     => 'array',
        'src'      => $doctrine['orm'],
    ],
    'App\ServiceProvider\DoctrineExtensionsServiceProvider' => [
        'register' => true,
    ],
    'Cekurte\Silex\Translation\Provider\TranslationServiceProvider' => [
        'register' => true,
    ],
    'Silex\Provider\HttpFragmentServiceProvider' => [
        'register' => true,
    ],
    'Silex\Provider\SessionServiceProvider' => [
        'register' => true,
    ],
    'Silex\Provider\UrlGeneratorServiceProvider' => [
        'register' => true,
    ],
    'Silex\Provider\ServiceControllerServiceProvider' => [
        'register' => true,
    ],
    'JDesrosiers\Silex\Provider\CorsServiceProvider' => [
        'register' => true,
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'cors.php',
    ],
    'Silex\Provider\MonologServiceProvider' => [
        'register' => true,
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'monolog.php',
    ],
    'Silex\Provider\SwiftmailerServiceProvider' => [
        'register' => true,
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'swiftmailer.php',
    ],
    'Silex\Provider\TranslationServiceProvider' => [
        'register' => true,
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'translation.php',
    ],
    'Silex\Provider\TwigServiceProvider' => [
        'register' => true,
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'twig.php',
    ],
    'Silex\Provider\WebProfilerServiceProvider' => [
        'register' => $app['debug'],
        'type'     => 'php',
        'src'      => CONFIG_PATH . DS . 'webprofiler.php',
    ],
    'Saxulum\DoctrineOrmManagerRegistry\Silex\Provider\DoctrineOrmManagerRegistryProvider' => [
        'register' => $app['debug'],
    ],
    'Saxulum\SaxulumWebProfiler\Provider\SaxulumWebProfilerProvider' => [
        'register' => $app['debug'],
    ],
];
