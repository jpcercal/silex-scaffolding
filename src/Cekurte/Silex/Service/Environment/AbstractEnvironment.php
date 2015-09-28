<?php

namespace Cekurte\Silex\Service\Environment;

use Cekurte\Silex\Service\Environment\EnvironmentInterface;

abstract class AbstractEnvironment implements EnvironmentInterface
{
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * Initialize
     */
    public function __construct($resource)
    {
        $this->setResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->resource;
    }
}
