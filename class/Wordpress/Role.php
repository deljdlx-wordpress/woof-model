<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Wordpress\Manager\Role as ManagerRole;
use WP_Roles;

class Role extends Entity
{

    /**
    * @var string
    */
    public $name;
    public $capabilities;

    /**
    * @var string
    */
    protected $id;



    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


    public function loadByName($name)
    {
        $role = ManagerRole::getByName($name);
        foreach($role as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }


    public function setCapability($capabilityName, $value)
    {
        $this->capabilities[$capabilityName] = $value;
        return $this;
    }

    public function delete()
    {
        //DOC https://developer.wordpress.org/reference/functions/remove_role/
        remove_role($this->name);
        return $this;
    }

    public function getWordpressRole()
    {
        if(!$this->wordpressRole) {
            $this->loadByName($this->name);
        }
        return $this->wordpressRole;
    }

    public function getCapabilities()
    {
        return $this->getWordpressRole()->capabilities;
    }

    // =======================================================================
    public function register()
    {
        $this->wordpressRole = add_role(
            $this->name,
            $this->label,
            $this->capabilities
        );

        return $this;
    }
}
