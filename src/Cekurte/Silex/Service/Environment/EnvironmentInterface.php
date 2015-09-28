<?php

namespace Cekurte\Silex\Service\Environment;

interface EnvironmentInterface
{
    /**
     * Set the resource
     *
     * @param mixed $resource
     *
     * @return EnvironmentInterface
     */
    public function setResource($resource);

    /**
     * Get the resource
     *
     * @return mixed
     */
    public function getResource();

    /**
     * @return mixed
     */
    public function process();
}
