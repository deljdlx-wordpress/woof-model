<?php

namespace Woof\Model\Wordpress;


class PostType extends Entity
{

    public $name;
    public $label;
    public $labels;
    public $description;
    public $public;
    public $hierarchical;
    public $exclude_from_search;
    public $publicly_queryable;
    public $show_ui;
    public $show_in_menu;
    public $show_in_nav_menus;
    public $show_in_admin_bar;
    public $menu_position;
    public $menu_icon;
    public $capability_type;
    public $map_meta_cap;
    public $register_meta_box_cb;
    public $taxonomies;
    public $has_archive;
    public $query_var;
    public $can_export;
    public $delete_with_user;
    public $template;
    public $template_lock;
    public $_builtin;
    public $_edit_link;
    public $cap;
    public $rewrite;
    public $show_in_rest;
    public $rest_base;
    public $rest_controller_class;
    public $rest_controller;


    public function getId()
    {
        return $this->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }


}
