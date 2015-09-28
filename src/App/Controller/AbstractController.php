<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpKernel\Exception\FatalErrorException;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * AbstractController
 */
abstract class AbstractController
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return Silex\Application
     */
    public function getApp()
    {
        return $this->app;
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
     * Get the validator instance
     *
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        $app = $this->getApp();

        if (!isset($app['validator'])) {
            throw new FatalErrorException('The ValidatorServiceProvider is not registered in this application');
        }

        return $app['validator'];
    }

    /**
     * Get a Doctrine DBAL instance
     *
     * @param  string $connection
     *
     * @return string
     */
    public function getDoctrineDbal($connection = '')
    {
        $app = $this->getApp();

        if (empty($connection)) {
            if (!isset($app['db'])) {
                throw new FatalErrorException('The DoctrineServiceProvider is not registered in this application');
            }

            return $app['db'];
        }

        if (!isset($app['dbs'][$connection])) {
            throw new FatalErrorException(sprintf(
                'The DoctrineServiceProvider is not registered in this application or the connection %s not exists',
                $connection
            ));
        }

        return $app['db'][$connection];
    }

    /**
     * Get a Doctrine Entity Manager instance
     *
     * @param  string $connection
     *
     * @return string
     */
    public function getDoctrineEm($connection = '')
    {
        $app = $this->getApp();

        if (empty($connection)) {
            if (!isset($app['orm.em'])) {
                throw new FatalErrorException('The DoctrineOrmServiceProvider is not registered in this application');
            }

            return $app['orm.em'];
        }

        if (!isset($app['orm.ems'][$connection])) {
            throw new FatalErrorException(sprintf(
                'The DoctrineOrmServiceProvider is not registered in this application or the connection %s not exists',
                $connection
            ));
        }

        return $app['orm.ems'][$connection];
    }

    /**
     * Render a view using the Twig Template Engine
     *
     * @param  string $view
     * @param  array  $params
     * @param  bool   $viewIsAbsolute
     *
     * @return string
     */
    public function render($view, array $params = [], $viewIsAbsolute = false)
    {
        $app = $this->getApp();

        if (!isset($app['twig'])) {
            throw new FatalErrorException('The TwigServiceProvider is not registered in this application');
        }

        if ($viewIsAbsolute === true) {
            return $app['twig']->render($view, $params);
        }

        $namespace = explode('\\', get_class($this));

        $path = '';

        foreach ($namespace as $ns) {
            if (stripos($ns, 'controller') !== false) {
                break;
            }
            $path .= $ns . '\\';
        }

        return $app['twig']->render(sprintf('%s/Resources/views/%s', $path, $view), $params);
    }
}
