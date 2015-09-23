<?php

return [
    'locale'                => Helpers::getEnv('TRANS_LOCALE'),
    'locale_fallbacks'      => Helpers::getEnv('TRANS_LOCALE_FALLBACKS'),
    'translator.domains'    => [
        'messages' => [
            'en' => require STORAGE_PATH_I18N . DIRECTORY_SEPARATOR . 'en.php'
        ]
    ],
];
