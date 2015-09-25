<?php

namespace App\Controller\Page;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function indexAction(Request $request)
    {
        return $this->render('Page/Home/index.twig.html', [
            'title' => $this->getApp()->trans('hello')
        ]);
    }
}
