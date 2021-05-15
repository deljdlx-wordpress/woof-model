<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Role as WordpressRole;

class Role extends Manager
{
    protected static $instance;

    protected $items;
    protected $itemsByAttribute = [];

    public function loadAll()
    {
        $wpRoles = wp_roles();
        return $wpRoles->roles;
    }


    public static function getByName($name)
    {
        return static::getById($name);
    }

    public static function getById($name)
    {
        return static::getByAttributeValue(
            'name',
            $name,
            function($name) {
                $wpRoles = wp_roles();
                return $wpRoles->get_role($name);
            }
        );
    }

}
