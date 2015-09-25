<?php

namespace Cekurte\Silex\Service;

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
        $env   = getenv($key);
        $value = strtolower($env);

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if ($value === 'null') {
            return null;
        }

        if (is_numeric($env)) {
            return is_int($env) ? (int) $env : (float) $env;
        }

        if (is_string($env) && isset($env[0])) {
            if ($env[0] === '[' && $env[strlen($env) - 1] === ']') {
                $env = explode(',', trim(str_replace(['"', "'"], '', substr($env, 1, -1))));
            }
        }

        return $env;
    }
}
