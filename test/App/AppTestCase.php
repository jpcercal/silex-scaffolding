<?php

namespace App\Test;

use Silex\WebTestCase;

class AppTestCase extends WebTestCase
{
    public function createApplication()
    {
        $app = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'app.php';

        return $app;
    }
}
