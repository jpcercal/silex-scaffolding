<?php

namespace Cekurte\Silex\Controller\Api;

use Cekurte\Silex\Controller\WebController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends WebController
{
    public function indexAction(Request $request)
    {
        return $this->render('Default/index.twig.html', [
            'title' => 'My Title'
        ]);
    }
}
