<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Taxonomy as WordpressTaxonomy;
use Woof\Model\Wordpress\Term as WordpressTerm;

class Taxonomy extends Manager
{
    protected static $instance;
    protected $items = null;

    protected $taxonomiesByName = [];

    public function loadAll()
    {


    }


    public static function getByName($name)
    {
        $instance = static::getInstance();

        $instance->taxonomiesByName[$name] = [];

        $wpTaxonomies = get_taxonomy($name);

        $taxonomy = new WordpressTaxonomy();
        $taxonomy->loadFromWordpress($wpTaxonomies);
        $instance->taxonomiesByName[$name] = $taxonomy;



        return $instance->taxonomiesByName[$name];
    }



}
