<?php

namespace Gazlab\Admin\Controllers;

use Gazlab\Admin\Models\GazlabAdministrators;
use Gazlab\Admin\Models\GazlabProfiles;

class AdministratorsController extends Resource
{
    
    public function initialize()
    {
        $this->view->setViewsDir(__DIR__ . '/../views/');
        
        parent::initialize();
    }

    public $menu = [
        'administrators',
        'name' => 'Administrators',
        'icon' => 'fa fa-user',
        'order' => 2
    ];

    public function table()
    {
        $this->column(['avatar', 'header' => '', 'orderable' => false, 'searchable' => false]);
        $this->column(['username']);

        $this->actions();
    }

    public function form()
    {
        $this->select(['profile_id', GazlabProfiles::find(), 'using'=>['id', 'name'], 'label' => 'Profile']);
        $this->textField(['username']);
        if ($this->isCreateAction()){
            $this->passwordField(['password']);
        }
        $this->fileField(['avatar']);
    }

    public function profileAction()
    {
        if ($this->request->isPost()){
            $params = $this->request->getPost('profile');
            
            $user = GazlabAdministrators::findFirst($this->identity->id);
            if ($user->save($params)){
                $this->flashSession->success('Data saved successfully');
                return $this->response->redirect($this->router->getRewriteUri());
            } else {
                foreach ($user->getMessages() as $message){
                    $this->flash->error($message);
                }
            }
        }

        $this->tag->setDefault('profile[username]', $this->identity->username);
    }

    public function deleteAccountAction()
    {
        $this->view->disable();

        $this->flashSession->warning('Successful account deleted');
        $this->response->redirect($this->router->getModuleName() . '/sessions/signOut');
    }
}

