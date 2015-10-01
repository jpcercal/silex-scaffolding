<?php

use Monolog\Logger;

return [
    'monolog.logfile' => STORAGE_PATH_LOG . '/app.log',
    'monolog.name'    => 'app',
    'monolog.level'   => Logger::WARNING,
];
