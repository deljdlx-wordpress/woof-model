<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\Entity;

abstract class Manager
{
    protected static $instance;

    protected $items = null;

    protected $itemsByAttribute = [];



    abstract public function loadAll();



    public function isLoaded()
    {
        if($this->items === null) {
            return false;
        }
        return true;
    }


    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     *
     * @return WPModelsPostType[]
     */
    public static function getAll($byId = false)
    {
        $instance = static::getInstance();

        if(!$instance->isLoaded()) {

            $instance->items = [];

            $wpInstances = $instance->loadAll();

            foreach($wpInstances as $wpData) {
                $entity = static::getEntity();
                $entity->loadFromWordpress($wpData);
                if($byId)  {
                    $instance->items[$entity->getId()] = $entity;
                }
                else {
                    $instance->items[] = $entity;
                }

            }
        }
        return $instance->items;
    }

    public static function getByAttributeValue($attribute, $value, $loader)
    {
        $instance = static::getInstance();

        if(isset($instance->itemsByAttribute[$attribute][$value])) {
            return $instance->itemsByAttribute[$attribute][$value];
        }

        $instance->itemsByAttribute[$attribute][$value] = [];

        $wpInstances = $loader($value);

        if(is_array($wpInstances)) {
            foreach($wpInstances as $index => $wpInstances) {
                $entity = static::createEntity($wpInstances);
                $instance->itemsByAttribute[$attribute][$value][] = $entity;
            }
        }
        else {
            $entity = static::getEntity();
            $entity->loadFromWordpress($wpInstances);
            $instance->itemsByAttribute[$attribute][$value] = $entity;
        }

        return $instance->itemsByAttribute[$attribute][$value];
    }

    public static function createEntity($wpInstance)
    {
        $entity = static::getEntity();
        $entity->loadFromWordpress($wpInstance);
        return $entity;
    }

    /**
     * @return Entity
     */
    public static function getEntity()
    {
        $entityClassName = str_replace('Manager\\', '',  static::class);
        return new $entityClassName();
    }


}
