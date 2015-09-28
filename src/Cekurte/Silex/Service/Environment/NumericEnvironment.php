<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\AbstractEnvironment;
use Cekurte\Silex\Service\Environment\EnvironmentInterface;

class NumericEnvironment extends AbstractEnvironment implements EnvironmentInterface
{
    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $resource = $this->getResource();

        if (!is_numeric($resource)) {
            throw new \RuntimeException('The resource type not is a numeric value');
        }

        return is_int($resource) ? (int) $resource : (float) $resource;
    }
}
