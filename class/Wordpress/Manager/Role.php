<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Role as WordpressRole;

class Role extends Manager
{
    protected static $instance;

    protected $items;
    protected $rolesByName = [];

    public function loadAll()
    {
        $this->items = [];

        $wpRoles = wp_roles();

        foreach($wpRoles->roles as $id => $roleData) {

            $role = new WordpressRole();
            $role->loadFromWordpress($roleData);
            $role->set('id', $id);


            $this->items[$id] = $role;

        }
        return $this->items;
    }


    public static function getByName($name)
    {
        return static::getById($name);
    }

    public static function getById($name)
    {
        $instance = static::getInstance();

        if(isset($instance->rolesByName[$name])) {
            return $instance->rolesByName[$name];
        }

        if($instance->isLoaded()) {
            if(isset($instance->items[$name])) {
                $instance->rolesByName[$name] = $instance->items[$name];
                return $instance->items[$name];
            }
        }


        $wpRoles = wp_roles();
        $roleData = $wpRoles->get_role($name);

        $role = new WordpressRole();
        $role->loadFromWordpress($roleData);
        $role->set('id', $name);

        $instance->rolesByName[$name] = $role;

        return $role;
    }

}
