<?php

namespace GazlabAdmin;

class Table extends \Phalcon\Mvc\User\Component
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
        return $this->view->getPartial(__DIR__ . '/../views/templates/table', $this->params);
    }
}
