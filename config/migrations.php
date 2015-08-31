<?php

return [
    'migrations.directory'  => ROOT_PATH . DIRECTORY_SEPARATOR . Helpers::getEnv('MIGRATIONS_DIRECTORY'),
    'migrations.name'       => Helpers::getEnv('MIGRATIONS_NAME'),
    'migrations.namespace'  => Helpers::getEnv('MIGRATIONS_NAMESPACE'),
    'migrations.table_name' => Helpers::getEnv('MIGRATIONS_TABLENAME'),
];
