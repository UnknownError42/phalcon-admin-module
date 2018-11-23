<?php

namespace GazlabAdmin;

class Column extends \Phalcon\Mvc\User\Component
{
    public $params;

    public function __construct($params)
    {
        $params['header'] = isset($params['header']) ? $params['header'] : ucwords(\Phalcon\Text::humanize($params[0]));
        $this->params = [
            'params' => $params
        ];
    }

    public function render()
    {
        return $this->view->getPartial('templates/column', $this->params);
    }
}
