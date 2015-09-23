<?php

use App\ServiceProvider\DoctrineExtensionsServiceProvider;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Tools\Console\ConsoleRunner;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Version;
use Silex\Application as SilexApplication;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\HelperSet;

// Silex Providers
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

// Doctrine Migration Commands
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;

// Doctrine ORM Commands
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;

$app = new SilexApplication();

$app['debug'] = Helpers::getEnv('APP_DEBUG');

$doctrine   = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'doctrine.php';
$migrations = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'migrations.php';

$app->register(new DoctrineServiceProvider(),    $doctrine['dbal']);
$app->register(new DoctrineOrmServiceProvider(), $doctrine['orm']);
$app->register(new DoctrineExtensionsServiceProvider());

$em = $app['orm.em'];

$helperSet = new HelperSet(array(
    'db'     => new ConnectionHelper($em->getConnection()),
    'em'     => new EntityManagerHelper($em),
    'dialog' => new DialogHelper(),
));

$cli = new Application('Silex Command Line Interface', Version::VERSION);
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

// Doctrine Migration Configuration
$config = new Configuration($em->getConnection());
$config->setMigrationsDirectory($migrations['migrations.directory']);
$config->setName($migrations['migrations.name']);
$config->setMigrationsNamespace($migrations['migrations.namespace']);
$config->setMigrationsTableName($migrations['migrations.table_name']);
$config->registerMigrationsFromDirectory($migrations['migrations.directory']);

$commands = [];

$commands[] = new DiffCommand();
end($commands)->setMigrationConfiguration($config);

$commands[] = new ExecuteCommand();
end($commands)->setMigrationConfiguration($config);

$commands[]= new GenerateCommand();
end($commands)->setMigrationConfiguration($config);

$commands[] = new MigrateCommand();
end($commands)->setMigrationConfiguration($config);

$commands[] = new StatusCommand();
end($commands)->setMigrationConfiguration($config);

$commands[] = new VersionCommand();
end($commands)->setMigrationConfiguration($config);

$commands[] = new MetadataCommand();
$commands[] = new ResultCommand();
$commands[] = new QueryCommand();
$commands[] = new CreateCommand();
$commands[] = new UpdateCommand();
$commands[] = new DropCommand();
$commands[] = new EnsureProductionSettingsCommand();
$commands[] = new ConvertDoctrine1SchemaCommand();
$commands[] = new GenerateRepositoriesCommand();
$commands[] = new GenerateEntitiesCommand();
$commands[] = new GenerateProxiesCommand();
$commands[] = new ConvertMappingCommand();
$commands[] = new RunDqlCommand();
$commands[] = new ValidateSchemaCommand();
$commands[] = new InfoCommand();
$commands[] = new MappingDescribeCommand();

$commands[] = new App\Command\ImportMappingDoctrineCommand();
end($commands)->setEntityManager($em);

$cli->addCommands($commands);

// Register All Doctrine DBAL Commands
ConsoleRunner::addCommands($cli);

return $cli;
