<?php

return [
    'dbal' => [
        'db.options'    => [
            'driver'    => Helpers::getEnv('DB_DRIVER'),
            'host'      => Helpers::getEnv('DB_HOST'),
            'dbname'    => Helpers::getEnv('DB_NAME'),
            'user'      => Helpers::getEnv('DB_USERNAME'),
            'password'  => Helpers::getEnv('DB_PASSWORD'),
            'charset'   => Helpers::getEnv('DB_CHARSET'),
            'port'      => Helpers::getEnv('DB_PORT'),
        ],
    ],
    'orm' => [
        'orm.proxies_dir'           => ROOT_PATH . DIRECTORY_SEPARATOR . Helpers::getEnv('DOCTRINE_ORM_PROXIES_DIRECTORY'),
        'orm.proxies_namespace'     => Helpers::getEnv('DOCTRINE_ORM_PROXIES_NAMESPACE'),
        'orm.auto_generate_proxies' => Helpers::getEnv('DOCTRINE_ORM_AUTO_GENERATE_PROXIES'),
        'orm.default_cache'         => Helpers::getEnv('DOCTRINE_ORM_DEFAULT_CACHE'),
        'orm.em.options' => [
            'mappings' => [
                [
                    'type'      => Helpers::getEnv('DOCTRINE_ORM_MAPPING_DEFAULT_TYPE'),
                    'namespace' => Helpers::getEnv('DOCTRINE_ORM_MAPPING_DEFAULT_NAMESPACE'),
                    'path'      => ROOT_PATH . DIRECTORY_SEPARATOR . Helpers::getEnv('DOCTRINE_ORM_MAPPING_DEFAULT_PATH'),
                ],
            ],
        ],
    ],
];
