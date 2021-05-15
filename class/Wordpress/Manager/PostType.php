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

    protected $itemsByName = [];



    public static function getByName($name)
    {

        $instance = static::getInstance();

        if(isset($instance->itemsByName[$name])) {
            return $instance->itemsByName[$name];
        }

        if($instance->items !== null) {
            if(isset($instance->items[$name])) {
                $instance->itemsByName[$name] = $instance->items[$name];
                return $instance->itemsByName[$name];
            }
        }

        $data = get_post_types([$name], 'objects');
        $postType = new WPModelsPostType();
        $postType->loadFromWordpress($data[0]);
        $instance->itemsByName[$postType->name] = $postType;
        return $instance->itemsByName[$name];
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

        $data = get_post_types([], 'objects');

        $this->items = [];
        foreach($data as $name => $postTypeDescriptor) {
            $postType = new WPModelsPostType();
            $postType->loadFromWordpress($postTypeDescriptor);
            $this->items[$postType->name] = $postType;
        }

        return $this->items;
    }


}
