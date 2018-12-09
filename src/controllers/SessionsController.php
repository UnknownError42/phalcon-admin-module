<?php

namespace Gazlab\Admin\Controllers;

class SessionsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setViewsDir(__DIR__ . '/../views/');
        
        parent::initialize();
    }

    public function signInAction()
    {
        if ($this->request->isPost()){
            $params = $this->request->getPost('sign_in');

            $user = \Gazlab\Admin\Models\GazlabAdministrators::findFirstByUsername($params['username']);
            if ($user != false){
                if ($this->security->checkHash($params['password'], $user->password)){
                    $this->session->set('uId', $user->id);
                    
                    return $this->response->redirect($this->router->getModuleName());
                } else {
                    $this->flash->error('Wrong password');
                }
            } else {
                $this->flash->warning('Account ' . $params['username'] . ' doesn\'t exist');
            }
        }
    }

    public function signOutAction()
    {
        $this->session->destroy();

        $this->response->redirect($this->router->getModuleName());
    }

}

