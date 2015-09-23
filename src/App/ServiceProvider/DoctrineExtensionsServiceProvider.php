<?php

namespace App\ServiceProvider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Gedmo\DoctrineExtensions;
use Gedmo\Loggable\LoggableListener;
use Gedmo\Sluggable\SluggableListener;
use Gedmo\Sortable\SortableListener;
use Gedmo\Timestampable\TimestampableListener;
use Gedmo\Translatable\TranslatableListener;
use Gedmo\Tree\TreeListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\Exception\FatalErrorException;

class DoctrineExtensionsServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        if (!isset($app['db.event_manager'])) {
            throw new FatalErrorException('The DoctrineServiceProvider is not registered in this application');
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_SLUGGABLE') === true) {
            $listener = new SluggableListener();
            $app['db.event_manager']->addEventSubscriber($listener);
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_TREE') === true) {
            $listener = new TreeListener();
            $app['db.event_manager']->addEventSubscriber($listener);
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_LOGGABLE') === true) {
            $listener = new LoggableListener();
            $app['db.event_manager']->addEventSubscriber($listener);
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_TIMESTAMPABLE') === true) {
            $listener = new TimestampableListener();
            $app['db.event_manager']->addEventSubscriber($listener);
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_TRANSLATABLE') === true) {
            $listener = new TranslatableListener();

            if (!isset($app['translator'])) {
                throw new FatalErrorException('The TranslationServiceProvider is not registered in this application');
            }

            $listener->setTranslatableLocale($app['translator']->getLocale());
            $listener->setDefaultLocale($app['translator']->getLocale());

            $app['db.event_manager']->addEventSubscriber($listener);
        }

        if (\Helpers::getEnv('DOCTRINE_EXTENSION_ENABLE_SORTABLE') === true) {
            $listener = new SortableListener();
            $app['db.event_manager']->addEventSubscriber($listener);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $doctrine = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'doctrine.php';

        $mappings = $doctrine['orm']['orm.em.options']['mappings'];

        $paths = [];

        foreach ($mappings as $mapping) {
            $paths[] = $mapping['path'];
        }

        $reader = new CachedReader(new AnnotationReader(), new ArrayCache());

        $driverChain = new DriverChain();

        DoctrineExtensions::registerMappingIntoDriverChainORM($driverChain, $reader);

        $annotationDriver = new AnnotationDriver($reader, $paths);

        foreach ($mappings as $mapping) {
            $driverChain->addDriver($annotationDriver, $mapping['namespace']);
        }

        if (!isset($app['orm.em'])) {
            throw new FatalErrorException('The DoctrineOrmServiceProvider is not registered in this application');
        }

        $app['orm.em']->getConfiguration()->setMetadataDriverImpl($driverChain);
    }
}
