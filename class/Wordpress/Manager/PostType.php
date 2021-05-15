<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\PostType as WPModelsPostType;

class PostType extends Manager
{

    protected static $instance;
    /**
     *
     * @var WPModelsPostType
     */
    protected $items = null;

    protected $itemsByAttribute = [];
    protected $itemsByName = [];



    public static function getByPostId($postId)
    {
        $postTypeName = get_post_type($postId, 'objects');

        $postType = static::getByAttributeValue(
            'name',
            $postTypeName,
            function($name) {
                $postType = get_post_types(
                    [
                        'name' => $name,
                    ],
                    'objects'
                );
                return reset($postType);
            }
        );
        return $postType;
    }



    public static function exists($name)
    {
        $postTypes = static::getAll();

        if(array_key_exists($name, $postTypes)) {
            return true;
        }
        return false;
    }


    /**
     *
     * @return WPModelsPostType[]
     */
    public function loadAll()
    {
        return get_post_types([], 'objects');
    }


}
