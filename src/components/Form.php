<?php

namespace GazlabAdmin;

class Form extends \Phalcon\Mvc\User\Component
{
    private $params;

    public function __construct($contents, $params = [])
    {
        $this->params = [
            'contents' => $contents,
            'params' => $params
        ];
    }

    public function render()
    {
        return $this->view->getPartial('templates/form', $this->params);
    }
}
