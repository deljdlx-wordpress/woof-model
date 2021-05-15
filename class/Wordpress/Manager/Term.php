<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Post as WordpressPost;
use Woof\Model\Wordpress\Term as WordpressTerm;

class Term extends Manager
{
    protected static $instance;
    protected $items = null;

    protected $termsByPostId = [];

    public function loadAll()
    {

        $this->items = [];

        $wpTerms = get_terms([
            // 'taxonomy' => 'categories',
            'number' => 0,
            'hide_empty' => false,
        ]);

        foreach($wpTerms as $termData) {
            $term = new WordpressTerm();
            $term->loadFromWordpress($termData);
            $this->items[$term->getId()] = $term;
        }

        return $term;
    }


    public static function getByPostId($postId)
    {

        $instance = static::getInstance();

        $instance->termsByPostId[$postId] = [];

        $terms = get_the_category($postId);
        foreach($terms as $termData) {
            $term = new WordpressTerm();
            $term->loadFromWordpress($termData);

            $instance->termsByPostId[$postId][$term->getId()] = $term;
        }

        return $instance->termsByPostId[$postId];
    }




}
