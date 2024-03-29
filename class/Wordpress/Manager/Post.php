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

    public static function getAllInherit() {
        $instance = static::getInstance();
        return $instance->getAllByStatus('inherit');
    }

    public static function getAllActive() {
        $instance = static::getInstance();
        return $instance->getAllByStatus(
            ['publish', 'future', 'draft', 'pending', 'private ']
        );
    }



    public function loadAll()
    {
        return get_posts([
            'numberposts' => -1,
            'post_type' => 'any',
            'post_status' => 'all'
        ]);
    }

    public static function getAllByType($type, $status = ['publish']) {

        return static::getByAttributeValue(
            'type',
            $type,
            function($type) use ($status) {
                return get_posts([
                    'numberposts' => -1,
                    'post_type' => $type,
                    'post_status' => $status
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

