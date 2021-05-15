<?php

namespace Woof\Model\Wordpress;



class Taxonomy extends Entity
{

    public $name;
    public $label;
    public $labels;
    public $description;
    public $public;
    public $publicly_queryable;
    public $hierarchical;
    public $show_ui;
    public $show_in_menu;
    public $show_in_nav_menus;
    public $show_tagcloud;
    public $show_in_quick_edit;
    public $show_admin_column;
    public $meta_box_cb;
    public $meta_box_sanitize_cb;
    public $object_type;
    public $cap;
    public $rewrite;
    public $query_var;
    public $update_count_callback;
    public $show_in_rest;
    public $rest_base;
    public $rest_controller_class;
    public $rest_controller;
    public $default_term;
    public $sort;
    public $args;
    public $_builtin;


    public function getName()
    {
        return $this->name;
    }

    public function getLabe()
    {
        return $this->label;
    }


}