<?php

namespace Cekurte\Silex\Service\LoaderService;

use Cekurte\Silex\Service\LoaderService\ConfigInterface;

class ConfigFactory
{
    use ConfigTrait;

    /**
     * Disable the constructor
     */
    private function __construct()
    {

    }

    /**
     * Create a instance of Config using the Static Factory Pattern
     *
     * @param  string $type
     *
     * @return ConfigInterface
     *
     * @throws \InvalidArgumentException
     */
    public static function create($type)
    {
        $allowedConfigTypes = self::getAllowedConfigTypes();

        if (!array_key_exists($type, $allowedConfigTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'The type "%s" is invalid, use one of this types %s.',
                $type,
                implode(', ', array_keys($allowedConfigTypes))
            ));
        }

        foreach ($allowedConfigTypes as $configType => $class) {
            if ($type === $configType) {
                $class = __NAMESPACE__ . '\\' . $class;
                return new $class();
            }
        }
    }
}
