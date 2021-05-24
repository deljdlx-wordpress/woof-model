<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Wordpress\Manager\Role as ManagerRole;
use WP_Roles;

class ACFFieldGroup extends Entity
{
    public $ID;
    public $key;
    public $title;
    public $fields;
    public $location;
    public $menu_order;
    public $position;
    public $style;
    public $label_placement;
    public $instruction_placement;
    public $hide_on_screen;
    public $active;
    public $description;
    public $_valid;


    public function getId()
    {
        return $this->ID;
    }

    public function getName()
    {
        return $this->title;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getLocation()
    {
        return $this->location;
    }


}
