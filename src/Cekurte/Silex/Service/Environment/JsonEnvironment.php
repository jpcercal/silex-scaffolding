<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\AbstractEnvironment;
use Cekurte\Silex\Service\Environment\EnvironmentInterface;

class JsonEnvironment extends AbstractEnvironment implements EnvironmentInterface
{
    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $resource = $this->getResource();

        if (!is_string($resource) ||
            !isset($resource[0])  ||
            $resource[0] !== '{'  ||
            substr($resource, strlen($resource) - 1) !== '}') {
            throw new \RuntimeException('The resource type not is a json value');
        }

        $resource = json_decode($resource, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(sprintf(
                'Error occurred while decoding the json string #%d "%s"',
                json_last_error(),
                json_last_error_msg()
            ));
        }

        return $resource;
    }
}
