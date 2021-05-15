<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Post as WordpressPost;

class Post extends Manager
{

    protected static $instance;

    /**
     * @var WordpressPost[]
     */
    protected $items = null;

    /**
     * @var WordpressPost[]
     */
    protected $itemsByAttribute = [];


    public static function getAllPublish() {
        $instance = static::getInstance();
        return $instance->getAllByStatus('publish');
    }


    public static function getAllDraft() {
        $instance = static::getInstance();
        return $instance->getAllByStatus('draft');
    }


    public function loadAll()
    {
        return get_posts([
            'numberposts' => -1,
            'post_type' => 'any',
            'post_status' => 'all'
        ]);
    }

    public static function getAllByType($type) {

        return static::getByAttributeValue(
            'type',
            $type,
            function($type) {
                return get_posts([
                    'numberposts' => -1,
                    'post_type' => 'any',
                    'post_status' => $type
                ]);
            }
        );
    }


    public static function getAllByStatus($status) {
        return static::getByAttributeValue(
            'status',
            $status,
            function($status) {
                return get_posts([
                    'numberposts' => -1,
                    'post_type' => 'any',
                    'post_status' => $status
                ]);
            }
        );
    }

}

