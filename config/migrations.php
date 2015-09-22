<?php

return [
    'migrations.directory'  => ROOT_PATH . DIRECTORY_SEPARATOR . Helpers::getEnv('DOCTRINE_MIGRATIONS_DIRECTORY'),
    'migrations.name'       => Helpers::getEnv('DOCTRINE_MIGRATIONS_NAME'),
    'migrations.namespace'  => Helpers::getEnv('DOCTRINE_MIGRATIONS_NAMESPACE'),
    'migrations.table_name' => Helpers::getEnv('DOCTRINE_MIGRATIONS_TABLENAME'),
];
