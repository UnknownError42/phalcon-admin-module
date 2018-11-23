<?php

namespace Gazlab\Admin\Models;

class ModelBase extends \Phalcon\Mvc\Model
{
    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
