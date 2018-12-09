<?php

namespace Gazlab\Admin\Controllers;

use GazlabAdmin\Table;
use GazlabAdmin\Column;
use GazlabAdmin\Form;
use \DataTables\DataTable;

class Resource extends ControllerBase
{
    private $columns = [];
    private $formGroups = [];
    private $model;
    private $controllerName;

    public function initialize()
    {
        $this->controllerName = $this->router->getControllerName();

        $this->model = \Phalcon\Text::camelize($this->controllerName);
        if (in_array($this->controllerName, array_keys($this->config->privateResources->toArray()))){
            $this->model = 'Gazlab\Admin\Models\Gazlab' . $this->model;
        }

        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->request->isAjax()) {
            $builder = $this->modelsManager->createBuilder()
                            ->from($this->model);
  
            $dataTables = new DataTable();
            $dataTables->fromBuilder($builder)->sendResponse();
        }

        if (!method_exists($this, 'table')){

        } else {
            $this->table();
        }

        $this->view->contents = [
            new Table($this->columns, ['box'=>true])
        ];
        $this->view->pick(__DIR__ . '/../views/templates/content');

        $columns = [];
        foreach ($this->columns as $column){
            $column->params['params']['data'] = $column->params['params'][0];
            
            $dtParams = [];
            foreach ($column->params['params'] as $key => $value){
                switch ($key){
                    case '0':
                    case 'header':
                        break;
                    case 'render':
                        $dtParams[] = $key . ': '.$value;
                        break;
                    default:
                        $dtParams[] = $key . ': '.(is_bool($value) ? (($value) ? 'true' : 'false') : '"'.$value.'"');
                }
            }
            $columns[] = '{'.join(', ', $dtParams).'}';
        }
        
        $columns = join(', ',$columns);
        $this->assets->addInlineJs($this->view->getPartial(__DIR__ . '/../views/templates/table.js', ['columns' => $columns]));
    }

    public function params()
    {
        $params = [];
        foreach ($this->request->get($this->controllerName) as $key => $value){
            if (!empty($value)){
                $params[$key] = $value;
            }
        }

        return $params;
    }

    public function createAction()
    {
        if ($this->request->isPost()){
            $className = $this->model;
            $model = new $className();
            if (!$model->save($this->params())){
                foreach($model->getMessages() as $error){
                    $this->flash->error($error);
                }
            } else {
                $this->flashSession->success('Data has been saved.');
                return $this->response->redirect(join('/', [$this->router->getModuleName(), $this->controllerName]));
            }
        }

        if (!method_exists($this, 'form')){

        } else {
            $this->form();
        }
        
        $this->view->contents = [
            new Form($this->formGroups, ['box' => true, 'title' => 'New'])
        ];
        $this->view->pick(__DIR__ . '/../views/templates/content');
    }

    public function updateAction($id)
    {
        $className = $this->model;
        $model = $className::findFirst($id);

        if ($this->request->isPost()){
            if (!$model->save($this->params())){
                foreach($model->getMessages() as $error){
                    $this->flash->error($error);
                }
            } else {
                $this->flashSession->success('Data has been saved.');
                return $this->response->redirect(join('/', [$this->router->getModuleName(), $this->controllerName]));
            }
        }

        if ($model){
            $defaults = [];
            foreach($model as $key => $value){
                $defaults[$this->controllerName.'['.$key.']'] = $value;
            }
            $this->tag->setDefaults($defaults);
        }

        if (!method_exists($this, 'form')){

        } else {
            $this->form();
        }

        $this->view->id = $id;
        $this->view->contents = [
            new Form($this->formGroups, ['box' => true, 'title' => 'Edit'])
        ];
        $this->view->pick(__DIR__ . '/../views/templates/content');
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        $className = $this->model;
        $model = $className::findFirst($id);

        if (!$model->delete()){
            foreach($model->getMessages() as $error){
                $this->flashSession->error($error);
            }
        } else {
            $this->flashSession->warning('Data has been deleted.');
        }

        return $this->response->redirect(join('/', [$this->router->getModuleName(), $this->controllerName]));
    }

    public function isCreateAction()
    {
        return $this->router->getActionName() === 'create';
    }

    public function isUpdateAction()
    {
        return $this->router->getActionName() === 'update';
    }

    public function column($params)
    {
        return array_push($this->columns, new Column($params));
    }

    public function actions()
    {
        $actions = [];
        if ($this->acl->isAllowed($this->identity->profile->name, $this->controllerName, 'update')) {
            $actions[] = '<a href="'.$this->url->get(join('/', [$this->router->getModuleName(), $this->controllerName, 'update'])).'/\'+row.DT_RowId+\'" class="btn btn-xs btn-default" title="Edit"><i class="fa fa-edit"></i></a>';
        }
        if ($this->acl->isAllowed($this->identity->profile->name, $this->controllerName, 'update')) {
            $popoverContent = $this->escaper->escapeHtml('<a href=\"' . $this->url->get(join('/', [$this->router->getModuleName(), $this->controllerName, 'delete'])) . '/').'\'+row.DT_RowId+\''.$this->escaper->escapeHtml('\" class=\"btn btn-sm btn-danger\">Yes</a> <a role=\"button\" class=\"btn btn-sm btn-default\">No</a>');
            $actions[] = '<a tabindex="0" role="button" data-toggle="popover" title="Are you sure?" data-content="' . $popoverContent . '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
        }
        
        $params = [
            '@actions',
            'header' => '',
            'searchable' => false,
            'orderable' => false,
            'render' => 'function(data, type, row, meta) {
                return \''.join(' ', $actions).'\';
            }'
        ];
        return array_push($this->columns, new Column($params));
    }

    public function formGroup($contents, $params = [])
    {
        $fields = [];
        foreach ($contents as $function => $fieldParams) {
            $fieldParams[0] = $this->router->getControllerName() . '['.$fieldParams[0].']';
            $fields[] = $this->tag->$function($fieldParams);
        }
        
        $params['label'] = isset($params['label']) ? $params['label'] : ucwords(\Phalcon\Text::humanize($params[0]));
        $params[0] = $this->router->getControllerName() . '['.$params[0].']';

        return array_push($this->formGroups, $this->view->getPartial(__DIR__ . '/../views/templates/formGroup', [
            'contents' => $fields,
            'params' => $params
        ]));
    }

    public function textField($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' form-control' : 'form-control';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function numericField($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' form-control' : 'form-control';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function textArea($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' form-control' : 'form-control';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function select($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' select2' : 'select2';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function selectStatic($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' select2' : 'select2';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function passwordField($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        $params['class'] = isset($params['class']) ? $params['class'] . ' form-control' : 'form-control';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }

    public function fileField($params)
    {
        $formGroupParams[0] = $params[0];
        if (isset($params['label'])) {
            $formGroupParams['label'] = $params['label'];
        }

        // $params['class'] = isset($params['class']) ? $params['class'] . ' form-control' : 'form-control';

        return $this->formGroup([
            __FUNCTION__ => $params
        ], $formGroupParams);
    }
}

