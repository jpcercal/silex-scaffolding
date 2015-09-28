<?php

use Cekurte\Environment\Environment;

return [
    'locale'           => Environment::get('TRANS_LOCALE'),
    'locale_fallbacks' => Environment::get('TRANS_LOCALE_FALLBACKS'),
];
