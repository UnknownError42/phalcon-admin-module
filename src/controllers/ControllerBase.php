<?php
namespace Gazlab\Admin\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Gazlab\Admin\Models\GazlabAdministrators;
use Gazlab\Admin\Models\GazlabPermissions;

class ControllerBase extends Controller
{
    public $area = 'public';
    public $identity;
    public $menu;

    public function getArea()
    {
        return $this->area;
    }

    public function setArea($area)
    {
        $this->area = $area;
    }

    public function onConstruct()
    {
        $this->installAssets();

        $this->assets->addInlineJs($this->view->getPartial('index.js'));
    }

    public function initialize()
    {
        $this->view->identity = $this->identity;
        $this->view->mainNavigation = $this->getResources();

        $title = isset($this->config->gazlab->title) ? $this->config->gazlab->title : 'GazlabAdmin';
        $this->tag->setTitle($title);

        $this->breadcrumbs->add('Home', $this->url->get($this->router->getModuleName()));
        if ($this->router->getControllerName() !== 'index'){
            $this->breadcrumbs->add(isset($this->menu['name']) ? $this->menu['name'] : ucwords(\Phalcon\Text::humanize($this->router->getControllerName())), $this->url->get(join('/', [$this->router->getModuleName(), $this->router->getControllerName()])));
        }
        if ($this->router->getActionName() !== 'index'){
            $this->breadcrumbs->add($this->router->getActionName(), $this->url->get(join('/', [$this->router->getModuleName(), $this->router->getControllerName(), $this->router->getActionName()])));
        }

        $this->view->setTemplateAfter($this->getArea());
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->session->has('uId')){
            $this->identity = GazlabAdministrators::findFirst($this->session->get('uId'));
            $this->setArea('private');
        }

        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
            
        if ($this->acl->isPrivate($controllerName, $actionName)) {
            if (!$this->identity){
                $dispatcher->forward([
                    'namespace' => 'Gazlab\Admin\Controllers',
                    'controller' => 'sessions',
                    'action' => 'signIn'
                ]);
                return false;
            }

            if (!in_array($controllerName, array_keys($this->config->privateResources->toArray()))){
                $dispatcher->setDefaultNamespace('');
            }

            if (!$this->acl->isAllowed($this->identity->profile->name, $controllerName, $actionName)) {
                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);
                    
                $dispatcher->forward([
                    'namespace' => 'Gazlab\Admin\Controllers',
                    'controller' => 'index',
                    'action' => 'error'
                ]);
                return false;
            }
        } else {
            if ($this->getArea() === 'private') {
                $dispatcher->forward([
                    'namespace' => 'Gazlab\Admin\Controllers',
                    'controller' => 'index',
                    'action' => 'error'
                ]);
                return false;
            }
        }
    }

    public function getResources()
    {
        $mainNavigation = [];

        $resources = GazlabPermissions::find([
            'columns' => ['distinct(resource) AS resource']
        ]);

        foreach ($resources as $resource){
            $className = \Phalcon\Text::camelize($resource->resource, '-') . 'Controller';

            if (!file_exists($this->config->application->adminControllersDir . $className . '.php')){
                continue;
            }

            $$className = new $className();
            $$className->menu[0] = $resource->resource;
            $$className->menu['name'] = isset($$className->menu['name']) ? $$className->menu['name'] : ucwords(\Phalcon\Text::humanize($resource->resource));
            $group = isset($$className->group[0]) ? $$className->group[0] : 'main_navigation';
            $mainNavigation[$group][] = $$className;
        }

        $mainNavigation['configurations'] = [
            new AdministratorsController()
        ];

        return $mainNavigation;
    }

    private function installAssets()
    {
        $assetsDir = BASE_PATH . '/public/gazlab_assets';
        if (!file_exists($assetsDir) && !is_dir($assetsDir)){
            @mkdir($assetsDir);
        }

        // Bootstrap
        $componentsDir = $assetsDir . '/bootstrap';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/bootstrap', $componentsDir);
        }

        // Font Awesome
        $componentsDir = $assetsDir . '/font-awesome';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/font-awesome', $componentsDir);
        }

        // Ionicons
        $componentsDir = $assetsDir . '/Ionicons';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/Ionicons', $componentsDir);
        }

        // jQuery 3
        $componentsDir = $assetsDir . '/jquery';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/jquery', $componentsDir);
        }

        // SlimScroll
        $componentsDir = $assetsDir . '/jquery-slimscroll';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/jquery-slimscroll', $componentsDir);
        }

        // FastClick
        $componentsDir = $assetsDir . '/fastclick';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/fastclick', $componentsDir);
        }

        // PACE
        $componentsDir = $assetsDir . '/PACE';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/PACE', $componentsDir);
        }

        // AdminLTE
        $componentsDir = $assetsDir . '/adminlte';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/dist', $componentsDir);
        }

        // DataTables
        $componentsDir = $assetsDir . '/datatables.net';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/datatables.net', $componentsDir);
        }

        // DataTables Bootstrap
        $componentsDir = $assetsDir . '/datatables.net-bs';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/datatables.net-bs', $componentsDir);
        }

        // Select2
        $componentsDir = $assetsDir . '/select2';
        if (!file_exists($componentsDir) && !is_dir($componentsDir)){
            $this->recursive_copy(BASE_PATH . '/vendor/almasaeed2010/adminlte/bower_components/select2', $componentsDir);
        }
    }

    private function recursive_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recursive_copy($src .'/'. $file, $dst .'/'. $file);
                }
                else {
                    copy($src .'/'. $file,$dst .'/'. $file);
                }
            }
        }
        closedir($dir);
    }
}
