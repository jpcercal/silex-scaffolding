<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\AbstractEnvironment;
use Cekurte\Silex\Service\Environment\EnvironmentInterface;

class NullEnvironment extends AbstractEnvironment implements EnvironmentInterface
{
    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $resource = strtolower($this->getResource());

        if ($resource !== 'null') {
            throw new \RuntimeException('The resource type not is a null value');
        }

        return null;
    }
}
