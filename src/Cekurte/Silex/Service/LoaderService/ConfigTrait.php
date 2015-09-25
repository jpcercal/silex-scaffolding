<?php

namespace Cekurte\Silex\Service\LoaderService;

use Cekurte\Silex\Service\LoaderService\ConfigInterface;

trait ConfigTrait
{
    /**
     * @return array
     */
    public function getAllowedConfigTypes()
    {
        return [
            key(ConfigInterface::TYPE_ARRAY)    => current(ConfigInterface::TYPE_ARRAY),
            key(ConfigInterface::TYPE_FILE_PHP) => current(ConfigInterface::TYPE_FILE_PHP),
        ];
    }
}
