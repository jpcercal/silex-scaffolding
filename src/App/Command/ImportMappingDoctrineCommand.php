<?php

/*
 * This file is part of the Doctrine Bundle
 *
 * The code was originally distributed inside the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 * (c) Doctrine Project, Benjamin Eberlei <kontakt@beberlei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Import Doctrine ORM metadata mapping information from an existing database.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class ImportMappingDoctrineCommand extends Command
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return EntityGenerator
     */
    protected function getEntityGenerator()
    {
        $entityGenerator = new EntityGenerator();
        $entityGenerator->setGenerateAnnotations(false);
        $entityGenerator->setGenerateStubMethods(true);
        $entityGenerator->setRegenerateEntityIfExists(false);
        $entityGenerator->setUpdateEntityIfExists(true);
        $entityGenerator->setNumSpaces(4);
        $entityGenerator->setAnnotationPrefix('ORM\\');

        return $entityGenerator;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:mapping:import')
            ->addOption('filter', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'A string pattern used to match entities that should be mapped.')
            ->addOption('force',  null, InputOption::VALUE_NONE, 'Force to overwrite existing mapping files.')
            ->setDescription('Imports mapping information from an existing database')
            ->setHelp(<<<EOT
The <info>doctrine:mapping:import</info> command imports mapping information
from an existing database:

<info>php app/console doctrine:mapping:import</info>

If you don't want to map every entity that can be found in the database, use the
<info>--filter</info> option. It will try to match the targeted mapped entity with the
provided pattern string.

<info>php app/console doctrine:mapping:import --filter=MyMatchedEntity</info>

Use the <info>--force</info> option, if you want to override existing mapping files:

<info>php app/console doctrine:mapping:import --force</info>
EOT
        );
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return \Helpers::getEnv('DOCTRINE_ORM_MAPPING_DEFAULT_NAMESPACE');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getEntityManager();

        $destPath = APP_PATH . DIRECTORY_SEPARATOR . preg_replace("#\\\#", DIRECTORY_SEPARATOR, $this->getNamespace());

        $type = 'annotation';

        $cme = new ClassMetadataExporter();

        $exporter = $cme->getExporter($type);
        $exporter->setOverwriteExistingFiles($input->getOption('force'));
        $exporter->setEntityGenerator($this->getEntityGenerator());

        $databaseDriver = new DatabaseDriver($em->getConnection()->getSchemaManager());
        $em->getConfiguration()->setMetadataDriverImpl($databaseDriver);

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);

        $metadata = $cmf->getAllMetadata();
        $metadata = MetadataFilter::filter($metadata, $input->getOption('filter'));

        if ($metadata) {
            $output->writeln(sprintf('Importing mapping information from "<info>%s</info>" entity manager', 'default'));

            foreach ($metadata as $class) {
                $className = $class->name;

                $class->name = sprintf('%s\\%s', $this->getNamespace(), $className);

                $path = $destPath . DIRECTORY_SEPARATOR . str_replace('\\', '.', $className) .'.php';

                $output->writeln(sprintf('  > writing <comment>%s</comment>', $path));

                $code = $exporter->exportClassMetadata($class);

                if (!is_dir($dir = dirname($path))) {
                    mkdir($dir, 0775, true);
                }

                file_put_contents($path, $code);

                chmod($path, 0664);
            }

            return 0;
        } else {
            $output->writeln('Database does not have any mapping information.', 'ERROR');
            $output->writeln('', 'ERROR');

            return 1;
        }
    }
}
