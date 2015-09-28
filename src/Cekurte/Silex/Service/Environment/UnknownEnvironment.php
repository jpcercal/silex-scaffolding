<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\AbstractEnvironment;
use Cekurte\Silex\Service\Environment\EnvironmentInterface;

class UnknownEnvironment extends AbstractEnvironment implements EnvironmentInterface
{
    /**
     * {@inheritdoc}
     */
    public function process()
    {
        return $this->getResource();
    }
}
