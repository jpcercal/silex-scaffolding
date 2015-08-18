<?php

namespace Cekurte\Silex\Controller;

use Symfony\Component\HttpKernel\Exception\FatalErrorException;

/**
 * The base WebController
 */
abstract class WebController
{
    /**
     * @return Silex\Application
     */
    public function getApp()
    {
        global $app;

        return $app;
    }

    /**
     * Generate a URL
     *
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function generateUrl($route, array $params = [])
    {
        $app = $this->getApp();

        if (!isset($app['url_generator'])) {
            throw new FatalErrorException('The UrlGeneratorServiceProvider is not registered in this application');
        }

        return $app['url_generator']->generate($route, $params);
    }

    /**
     * Get a Doctrine DBAL
     *
     * @param  string $connection
     *
     * @return string
     */
    public function getDb($connection)
    {
        $app = $this->getApp();

        if (empty($connection)) {
            if (!isset($app['db'])) {
                throw new FatalErrorException('The DoctrineServiceProvider is not registered in this application');
            }

            return $app['db'];
        }

        if (!isset($app['dbs'][$connection])) {
            throw new FatalErrorException(sprintf('The DoctrineServiceProvider is not registered in this application or the connection %s not exists', $connection));
        }

        return $app['db'][$connection];
    }

    /**
     * Render a view using the Twig Template Engine
     *
     * @param  string $view
     * @param  array $params
     *
     * @return string
     */
    public function render($view, array $params = [])
    {
        $app = $this->getApp();

        if (!isset($app['twig'])) {
            throw new FatalErrorException('The TwigServiceProvider is not registered in this application');
        }

        $calledClass = explode('\\', get_called_class());

        return $app['twig']->render(sprintf('Resources/views/%s', $view), $params);
    }
}
