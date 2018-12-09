<?php

namespace Gazlab\Admin\Controllers;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setViewsDir(__DIR__ . '/../views/');
        
        parent::initialize();
    }

    public function indexAction()
    {
        // $this->dispatcher->forward([
        //     'controller' => 'sessions',
        //     'action' => 'signIn'
        // ]);
    }

    public function errorAction()
    {
        
    }

}

