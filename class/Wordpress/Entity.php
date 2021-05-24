<?php

namespace Woof\Model\Wordpress;

use Phi\Traits\Introspectable;
use ReflectionClass;
use Woof\Model\Exception;
use Woof\Model\Wordpress\Manager\Manager;
use Woof\Model\Wordpress\Traits\Acf;

class Entity
{


    use Introspectable;
    use Acf;


    public $__id;


    /**
     * Wordpress native object
     */
    private $wordpressIntance;

    /**
     * Database access object
     *
     * @var Database
     */
    protected $wpdb;

    /**
     * @var Manager
     */
    protected $manager = null;

    /**
     *
     * @var boolean
     */
    protected $loaded = false;


    public function __construct()
    {
        $this->wpdb = Database::getInstance();

        /*
        if(static::$fieldGroups == null) {
            $this->loadACFFieldGroups();
        }
        */

        $this->loadManager();
    }


    public function getId()
    {

        if($this->__id !== null) {
            return $this->__id;
        }

        if(property_exists($this, 'ID')) {
            return $this->ID;
        }
        elseif(property_exists($this, 'id')) {
            return $this->id;
        }

        return false;
    }



    protected function loadManager()
    {
        $classBaseName = basename(str_replace('\\', '/', get_class($this)));
        $classDirName = dirname(str_replace('\\', '/', get_class($this)));
        $managerClassName = str_replace('/', '\\', $classDirName) .'\\Manager\\' . $classBaseName;

        $this->manager = new $managerClassName();
        return $this;
    }


    public function set($attribute, $value)
    {
        $this->$attribute = $value;
        return $this;
    }


    public function get($attribute, $default = null)
    {
        if(property_exists($this, $attribute)) {
            return $this->$attribute;
        }
        else {
            return $default;
        }
    }


    /**
     * @param  $wordpressIntance
     * @return $this
     */
    public function loadFromWordpress($wordpressIntance)
    {
        $this->wordpressIntance = $wordpressIntance;

        foreach($wordpressIntance as $attribute => $value) {
            if(is_object($wordpressIntance)) {
                $this->$attribute = &$wordpressIntance->$attribute;
            }
            else {
                $this->$attribute = &$wordpressIntance[$attribute];
            }

        }

        $this->loaded = true;

        return $this;
    }

    public function getWordpress()
    {
        if(!$this->loaded) {
            throw new Exception('Entity not loaded');
        }
        return $this->wordpressIntance;
    }

    public static function getFromWordpress($wordpressIntance)
    {
        $instance = new static();
        $instance->loadFromWordpress($wordpressIntance);
        return $instance;
    }


}
