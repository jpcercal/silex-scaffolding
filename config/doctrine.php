<?php

return [
    'db.options'    => [
        'driver'    => Helpers::getEnv('DB_DRIVER'),
        'host'      => Helpers::getEnv('DB_HOST'),
        'dbname'    => Helpers::getEnv('DB_NAME'),
        'user'      => Helpers::getEnv('DB_USERNAME'),
        'password'  => Helpers::getEnv('DB_PASSWORD'),
        'charset'   => Helpers::getEnv('DB_CHARSET'),
        'port'      => Helpers::getEnv('DB_PORT'),
    ],
];
