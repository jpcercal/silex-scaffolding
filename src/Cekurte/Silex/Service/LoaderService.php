<?php

namespace Cekurte\Silex\Service;

use Cekurte\Silex\Service\LoaderService\ArrayConfig;
use Cekurte\Silex\Service\LoaderService\ConfigInterface;
use Silex\Application;

class LoaderService
{
    /**
     * @var string
     */
    private $provider;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param string $provider
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        if (!$this->config instanceof ConfigInterface) {
            $this->config = new ArrayConfig();
            $this->config->setResource([]);
        }

        return $this->config;
    }

    /**
     * @param ConfigInterface config
     *
     * @return LoadProvider
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param  Application $application
     *
     * @return Application
     */
    public function register(Application $application)
    {
        $provider = $this->getProvider();
        $config   = $this->getConfig();

        return $application->register(new $provider(), $config->process());
    }
}
