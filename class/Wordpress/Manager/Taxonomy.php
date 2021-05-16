<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Taxonomy as WordpressTaxonomy;
use Woof\Model\Wordpress\Term as WordpressTerm;

class Taxonomy extends Manager
{
    protected static $instance;
    protected $items = null;
    protected $itemsByAttribute = [];

    public function loadAll()
    {
        $taxonomies = get_taxonomies([

        ], 'objects');
        return $taxonomies;

    }

    public static function getByName($name)
    {
        $taxonomy = static::getByAttributeValue(
            'name',
            $name,
            function($name) {
                return get_taxonomy($name);
            }
        );
        return $taxonomy;
    }
}
