<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Wordpress\Manager\Taxonomy;
use Woof\Model\Wordpress\Taxonomy as WordpressTaxonomy;

class Term extends Entity
{

    public $term_id = null;
    public $name = null;
    public $slug = null;
    public $term_group = null;
    public $term_taxonomy_id = null;
    public $taxonomy = null;
    public $description = null;
    public $parent = null;
    public $count = null;
    public $filter = null;
    public $cat_ID = null;
    public $category_count = null;
    public $category_description = null;
    public $cat_name = null;
    public $category_nicename = null;
    public $category_parent = null;


    protected $taxonomyInstance;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->term_id;
    }

    public function getLabel() {
        return $this->getName();
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Undocumented function
     *
     * @return WordpressTaxonomy
     */
    public function getTaxonomy()
    {
        if($this->taxonomyInstance === null) {
            $this->taxonomyInstance = Taxonomy::getByName($this->taxonomy);
        }
        return $this->taxonomyInstance;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return get_category_link($this->getId());
    }


    /**
     * @return \WP_Term
     */
    public function getWordpressTerm()
    {
        return $this->wordpressTerm;
    }

}
