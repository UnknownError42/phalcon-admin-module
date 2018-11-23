<?php

namespace Gazlab\Admin\Models;

class GazlabPermissions extends ModelBase
{

    /**
     *
     * @var integer
     */
    public $profile_id;

    /**
     *
     * @var string
     */
    public $resource;

    /**
     *
     * @var string
     */
    public $action;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("gazlab_permissions");
        $this->belongsTo('profile_id', 'Gazlab\Admin\Models\GazlabProfiles', 'id', ['alias' => 'Profile']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'gazlab_permissions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabPermissions[]|GazlabPermissions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabPermissions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
