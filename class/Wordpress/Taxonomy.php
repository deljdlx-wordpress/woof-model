<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Exception;

use function Woof\slugify;

class Taxonomy extends Entity
{

    public $name;
    public $label;
    public $labels = [];
    public $description = '';
    public $public = true;
    public $publicly_queryable = true;
    public $hierarchical = false;
    public $show_ui = true;
    public $show_in_menu = true;
    public $show_in_nav_menus = true;
    public $show_tagcloud = true;
    public $show_in_quick_edit = true;
    public $show_admin_column = false;
    public $meta_box_cb;
    public $meta_box_sanitize_cb;

    public $cap;
    public $rewrite = true;
    public $query_var;
    public $update_count_callback;

    public $show_in_rest = true;
    public $rest_base;
    public $rest_controller_class;
    public $rest_controller;
    public $default_term;
    public $sort;
    public $args;

    public $_builtin = false;

    public $object_type = [];



    public function getName()
    {
        return $this->name;
    }


    public function getLabel()
    {
        return $this->label;
    }


    public function setLabel($label)
    {
        $this->label = $label;
        $this->name = slugify($label);
        return $this;
    }


    public function addPostType($postType)
    {
        if(is_string($postType)) {
            $this->object_type[] = $postType;
        }
        elseif($postType instanceof PostType) {
            $this->object_type[] = $postType->getName();
        }
        else {
            throw new Exception('Invalid post type');
        }
    }


    public function register()
    {

        // DOC CUSTOM TAXO register https://developer.wordpress.org/reference/functions/register_taxonomy/
        add_action('init', function() {
            register_taxonomy(
                $this->name,
                $this->object_type,
                $this->getPublicPropertiesValues()
            );
        });
    }
}
