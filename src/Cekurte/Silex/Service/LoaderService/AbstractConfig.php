<?php

namespace Cekurte\Silex\Service\LoaderService;

abstract class AbstractConfig implements ConfigInterface
{
    use ConfigTrait;

    /**
     * @var array
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $resource;

    /**
     * Check the type of config
     *
     * @param  string  $type
     *
     * @return boolean
     */
    protected function isType($type)
    {
        return key($this->getType()) === $type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->resource;
    }
}
