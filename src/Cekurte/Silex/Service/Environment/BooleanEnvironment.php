<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\AbstractEnvironment;
use Cekurte\Silex\Service\Environment\EnvironmentInterface;

class BooleanEnvironment extends AbstractEnvironment implements EnvironmentInterface
{
    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $resource = strtolower($this->getResource());

        if (!in_array($resource, ['false', 'true'])) {
            throw new \RuntimeException('The resource type not is a boolean value');
        }

        return $resource === 'false' ? false : true;
    }
}
