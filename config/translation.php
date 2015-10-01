<?php

use Cekurte\Environment\Environment;

return [
    'locale'                => Environment::get('TRANS_LOCALE'),
    'locale_fallbacks'      => Environment::get('TRANS_LOCALE_FALLBACKS'),
    'translation.directory' => STORAGE_PATH_I18N,
];
