<?php

use Cekurte\Silex\Service\Environment;

return [
    'swiftmailer.use_spool' => Environment::get('SWIFTMAILER_USE_SPOOL'),
    'swiftmailer.options'   => [
        'host'       => Environment::get('SMTP_HOST'),
        'port'       => Environment::get('SMTP_PORT'),
        'username'   => Environment::get('SMTP_USERNAME'),
        'password'   => Environment::get('SMTP_PASSWORD'),
        'encryption' => Environment::get('SMTP_ENCRYPTION'),
        'auth_mode'  => Environment::get('SMTP_AUTH_MODE'),
    ],
];
