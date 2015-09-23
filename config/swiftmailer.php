<?php

return [
    'swiftmailer.use_spool' => Helpers::getEnv('SWIFTMAILER_USE_SPOOL'),
    'swiftmailer.options'   => [
        'host'       => Helpers::getEnv('SMTP_HOST'),
        'port'       => Helpers::getEnv('SMTP_PORT'),
        'username'   => Helpers::getEnv('SMTP_USERNAME'),
        'password'   => Helpers::getEnv('SMTP_PASSWORD'),
        'encryption' => Helpers::getEnv('SMTP_ENCRYPTION'),
        'auth_mode'  => Helpers::getEnv('SMTP_AUTH_MODE'),
    ],
];
