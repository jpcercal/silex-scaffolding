<?php

namespace Cekurte\Silex;

use Silex\Application as App;

class Application extends App
{
    use App\TwigTrait;
    use App\UrlGeneratorTrait;
    use App\SwiftmailerTrait;
    use App\MonologTrait;
    use App\TranslationTrait;
}
