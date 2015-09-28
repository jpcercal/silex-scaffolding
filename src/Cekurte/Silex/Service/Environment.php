<?php

namespace Cekurte\Silex\Service;

use Cekurte\Silex\Service\Environment\ArrayEnvironment;
use Cekurte\Silex\Service\Environment\BooleanEnvironment;
use Cekurte\Silex\Service\Environment\JsonEnvironment;
use Cekurte\Silex\Service\Environment\NullEnvironment;
use Cekurte\Silex\Service\Environment\NumericEnvironment;
use Cekurte\Silex\Service\Environment\UnknownEnvironment;

class Environment
{
    /**
     * Constructor disabled
     */
    private function __construct()
    {

    }

    /**
     * Get value from environment
     *
     * @static
     * @param string $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        $env      = getenv($key);
        $envLower = strtolower($env);

        $environment = new UnknownEnvironment($env);

        if (in_array($envLower, ['true', 'false'])) {
            $environment = new BooleanEnvironment($env);
        } elseif ($envLower === 'null') {
            $environment = new NullEnvironment($env);
        } elseif (is_numeric($env)) {
            $environment = new NumericEnvironment($env);
        } elseif (is_string($env) && isset($env[0]) && $env[0] === '[') {
            $environment = new ArrayEnvironment($env);
        } elseif (is_string($env) && isset($env[0]) && $env[0] === '{') {
            $environment = new JsonEnvironment($env);
        }

        return $environment->process();
    }
}
