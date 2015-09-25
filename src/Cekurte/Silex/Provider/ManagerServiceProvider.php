<?php

namespace Cekurte\Silex\Provider;

use Cekurte\Silex\Service\LoaderService;
use Cekurte\Silex\Service\LoaderService\ConfigFactory;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        if (isset($app['cors'])) {
            $app->after($app["cors"]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        if (!empty($app['cekurte.manager.providers'])) {
            foreach ($app['cekurte.manager.providers'] as $provider => $config) {
                if (isset($config['register']) && $config['register'] === true) {
                    $loader = new LoaderService($provider);

                    if (isset($config['type'])) {
                        $configuration = ConfigFactory::create($config['type']);

                        if (isset($config['src'])) {
                            $configuration->setResource($config['src']);
                        }

                        $loader->setConfig($configuration);
                    }

                    $loader->register($app);
                }
            }
        }
    }
}
