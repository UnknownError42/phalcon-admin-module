<?php

namespace Gazlab\Admin\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // $this->dispatcher->forward([
        //     'controller' => 'sessions',
        //     'action' => 'signIn'
        // ]);
    }

    public function errorAction()
    {
        echo '404';
    }

}

