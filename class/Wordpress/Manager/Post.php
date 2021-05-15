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
    protected $itemsByStatus = [];
    protected $itemsByType = [];



    public static function getAllByType($type) {
        $instance = static::getInstance();

        if(!isset($instance->itemsByType[$type])) {
            $instance->loadByType($type);
        }
        return $instance->itemsByType[$type];
    }


    public static function getAllByStatus($status) {
        $instance = static::getInstance();

        if(!isset($instance->itemsByStatus[$status])) {
            $instance->loadByStatus($status);
        }
        return $instance->itemsByStatus[$status];
    }


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
        $this->items = [];

        $posts = get_posts([
            'numberposts' => -1,
            'post_type' => 'any',
            'post_status' => 'all'
        ]);

        foreach($posts as $post) {
            $object = new WordpressPost();
            $object->loadFromWordpress($post);
            $this->items[$object->getId()] = $object;
        }
        return $this->items;
    }


    public function loadByStatus($status)
    {
        $this->itemsByStatus[$status] = [];

        $posts = get_posts([
            'numberposts' => -1,
            'post_type' => 'any',
            'post_status' => $status
        ]);

        foreach($posts as $post) {
            $object = new WordpressPost();
            $object->loadFromWordpress($post);
            $this->itemsByStatus[$status][$object->getId()] = $object;
        }
        return $this->itemsByStatus[$status];
    }

    public function loadByType($type)
    {
        $this->itemsByType[$type] = [];

        $posts = get_posts([
            'numberposts' => -1,
            'post_type' => 'any',
            'post_status' => $type
        ]);

        foreach($posts as $post) {
            $object = new WordpressPost();
            $object->loadFromWordpress($post);
            $this->itemsByType[$type][$object->getId()] = $object;
        }
        return $this->itemsByType[$type];
    }

}

