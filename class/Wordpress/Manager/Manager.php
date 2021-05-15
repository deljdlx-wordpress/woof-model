<?php

namespace Woof\Model\Wordpress\Manager;


abstract class Manager
{
    protected static $instance;

    protected $items = null;

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
    public static function getAll()
    {
        $instance = static::getInstance();

        if(!$instance->isLoaded()) {
            $instance->loadAll();
        }
        return $instance->items;
    }

}
