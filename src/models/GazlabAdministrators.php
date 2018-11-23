<?php

namespace Gazlab\Admin\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\PasswordStrength;
use Phalcon\Security;

class GazlabAdministrators extends ModelBase
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
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("gazlab_administrators");
        $this->belongsTo('profile_id', 'Gazlab\Admin\Models\GazlabProfiles', 'id', ['alias' => 'Profile']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'gazlab_administrators';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabAdministrators[]|GazlabAdministrators|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GazlabAdministrators|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'username',
            new Uniqueness([
                'message' => 'Username not avalaible'
            ])
        );

        return $this->validate($validator);
    }

    public function beforeCreate()
    {
        $validator = new Validation();

        $validator->add(
            'password',
            new PasswordStrength()
        );

        return $this->validate($validator);
    }

    public function beforeUpdate()
    {
        $security = new Security();

        if (!empty($this->password)){
            $this->password = $security->hash($this->password);
        }
    }
}