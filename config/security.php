<?php

use Silex\Application;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;

global $app;

return [
    'security.role_hierarchy' => [
        'ROLE_USER'        => [],
        'ROLE_ADMIN'       => ['ROLE_USER'],
        'ROLE_SUPER_ADMIN' => ['ROLE_ADMIN'],
    ],
    'security.access_rules' => [
        ['^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'],
        ['^.+$',     'ROLE_USER'],
    ],
    'security.firewalls' => [
        'dev' => [
            'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
            'security' => false
        ],
        'default' => [
            'pattern'   => '^.*$',
            'anonymous' => true,
            'form' => [
                'login_path'          => '/login',
                'check_path'          => '/login_check',
                'default_target_path' => '/',
            ],
            'logout' => [
                'logout_path'         => '/logout',
                'target'              => '/',
                'invalidate_session'  => true,
            ],
            'users' => $app->share(function (Application $app) {
                return new EntityUserProvider($app['doctrine'], 'App\Entity\User', 'username');
            }),
        ],
    ],
];
