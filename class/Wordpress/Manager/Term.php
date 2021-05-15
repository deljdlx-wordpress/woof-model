<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Post as WordpressPost;
use Woof\Model\Wordpress\Term as WordpressTerm;

class Term extends Manager
{
    protected static $instance;
    protected $items = null;

    protected $itemsByAttribute = [];

    public function loadAll()
    {
        return get_terms([
            // 'taxonomy' => 'categories',
            'number' => 0,
            'hide_empty' => false,
        ]);
    }


    public static function getByPostId($postId)
    {
        return static::getByAttributeValue(
            'postId',
            $postId,
            function($postId) {
                return get_the_category($postId);
            }
        );
    }




}
