<?php

namespace Gazlab\Admin\Models;

class GazlabProfiles extends ModelBase
{

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $active;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("gazlab_profiles");
        $this->hasMany('id', 'Gazlab\Admin\Models\GazlabPermissions', 'profile_id', ['alias' => 'Permissions']);
        $this->hasMany('id', 'Gazlab\Admin\Models\GazlabUsers', 'profile_id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'gazlab_profiles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabProfiles[]|GazlabProfiles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabProfiles|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
