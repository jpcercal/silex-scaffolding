<?php

namespace Cekurte\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Translator;
use Symfony\Component\HttpKernel\Exception\FatalErrorException;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class TranslationServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        if (!isset($app['translator'])) {
            throw new FatalErrorException('The TranslationServiceProvider is not registered in this application');
        }

        $translatorClosure = function (Translator $translator, Application $app) {

            $translator->addLoader('yaml', new YamlFileLoader());

            $iterator = new \DirectoryIterator(STORAGE_PATH_I18N);

            foreach ($iterator as $item) {
                if ($this->fileIsAllowed($item)) {
                    $translator->addResource('yaml', $item->getPathname(), $this->getLocale($item));
                }
            }

            return $translator;
        };

        $app['translator'] = $app->share($app->extend('translator', $translatorClosure));
    }

    /**
     * @param  \DirectoryIterator $currentItem
     *
     * @return bool
     */
    protected function fileIsAllowed(\DirectoryIterator $currentItem)
    {
        $allowExtensions = ['yml', 'yaml'];

        return $currentItem->isFile() && in_array($currentItem->getExtension(), $allowExtensions);
    }

    /**
     * @param  \DirectoryIterator $currentItem
     *
     * @return string
     */
    protected function getLocale(\DirectoryIterator $currentItem)
    {
        return substr($currentItem->getFilename(), 0, (strlen($currentItem->getExtension()) + 1) * -1);
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {

    }
}
