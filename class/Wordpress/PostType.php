<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Wordpress\Manager\Post;
use Woof\Model\Wordpress\Manager\PostType as ManagerPostType;
use Woof\Model\Wordpress\Post as WordpressPost;

use function Woof\slugify;

class PostType extends Entity
{


    // DOC CPT register_post_type https://developer.wordpress.org/reference/functions/register_post_type/

    /* menu_position
    2 Dashboard
    4 Separator
    5 Posts
    10 Media
    15 Links
    20 Pages
    25 Comments
    59 Separator
    60 Appearance
    65 Plugins
    70 Users
    75 Tools
    80 Settings
    99 Separator
    */

    /* menu_icon
    DOC CPT Dashicon https://developer.wordpress.org/resource/dashicons/#money
    */


    public $name;
    public $label;
    public $labels = [];
    public $description = '';
    public $public = true;
    public $hierarchical = false;
    public $exclude_from_search = false;
    public $publicly_queryable = false;
    public $show_ui = true;
    public $show_in_menu = true;
    public $show_in_nav_menus = true;
    public $show_in_admin_bar = null;
    public $menu_position = 4;
    public $menu_icon = 'dashicons-format-aside';
    public $capability_type = 'post';

    public $map_meta_cap = true;

    public $register_meta_box_cb;
    public $taxonomies;
    public $has_archive = true;
    public $query_var;
    public $can_export = true;
    public $delete_with_user = true;
    public $template;
    public $template_lock;
    public $_builtin;
    public $_edit_link;


    /*
    [cap] => stdClass Object
        // Meta capabilities
        [edit_post]		 => "edit_{$capability_type}"
        [read_post]		 => "read_{$capability_type}"
        [delete_post]		 => "delete_{$capability_type}"

        // Primitive capabilities used outside of map_meta_cap():

        [edit_posts]		 => "edit_{$capability_type}s"
        [edit_others_posts]	 => "edit_others_{$capability_type}s"
        [publish_posts]		 => "publish_{$capability_type}s"
        [read_private_posts]	 => "read_private_{$capability_type}s"

        // Primitive capabilities used within map_meta_cap():

        [read]                   => "read",
        [delete_posts]           => "delete_{$capability_type}s"
        [delete_private_posts]   => "delete_private_{$capability_type}s"
        [delete_published_posts] => "delete_published_{$capability_type}s"
        [delete_others_posts]    => "delete_others_{$capability_type}s"
        [edit_private_posts]     => "edit_private_{$capability_type}s"
        [edit_published_posts]   => "edit_published_{$capability_type}s"
        [create_posts]           => "edit_{$capability_type}s"
    */
    public $cap;
    public $rewrite;

    public $show_in_rest = true;
    public $rest_base;
    public $rest_controller_class = 'WP_REST_Posts_Controller';
    public $rest_controller;


    /**
     * @var ManagerPostType
     */
    protected $manager;


    public $supports = [
        'title',
        'editor',
        // 'excerpt',
        'author',
        'thumbnail',
        // 'trackbacks',
        // 'custom-fields',
        // 'comments',
        // 'revisions',
        // 'page-attributes',
        // DOC CPT post-formats posthttps://wordpress.org/support/article/post-formats/
        // 'post-formats'
    ];


    // ==============================================================================================================
    // ==============================================================================================================


    public function __construct($label = null, $name = null)
    {
        parent::__construct();

        if($label) {
            $this->setLabel($label);
        }

        if($name !== null) {
            $this->name = $name;
        }
    }

    /**
     * @return WordpressPost[]
     */
    public function getPosts()
    {
        return Post::getAllByType($this->getName());
    }

    /**
     * @return this
     */
    public function loadByName($name)
    {
        return $this->manager->getByName($name, $this);
    }

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

    /**
     * @param string $label
     * @return this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        $this->name = slugify($label);
        return $this;
    }



    /**
     * @return this
     */
    public function enableExcerpt()
    {
        return $this->enableSupport('excerpt');
    }

    /**
     * @return this
     */
    public function hideFromMenu()
    {
        $this->show_in_menu = false;
        return $this;
    }

    /**
     *
     * @param string $support
     * @return this
     */
    public function enableSupport($support)
    {
        if(!in_array($support, $this->supports)) {
            $this->supports[] = $support;
        }
        return $this;
    }

    public function disableSupport($support)
    {
        if(($key = array_search($support, $this->supports)) !== false) {
            unset($this->supports[$key]);
        }
        return $this;
    }


    public function getSupports()
    {
        return get_all_post_type_supports($this->getName());
    }

    public function register()
    {
        // création du post type
        add_action('init', function() {
            register_post_type($this->name, $this->getPublicPropertiesValues());
        });

        // désactivation de gutenberg
        // 10 représente la priorité de la fonction; 10 souvent valeur par défaut
        // 2 représente le nombre de paramètre que wordpress va récupéré
        // add_filter('use_block_editor_for_post_type', [$this, 'disableGutemberg'], 10, 2);

        // on donne à l'administateur les droits sur le custom post type
        // add_action('admin_init', [$this, 'addCapabilitiesToAdmin']);
    }
}
