<?php

namespace Woof\Model\Wordpress;

class PostMeta
{

    public $name;
    public $value;

    /**
     * @var Post
     */
    protected $post;
    protected $rawValue = null;
    protected $serialized = false;

    public function __construct($name, $value = null, $post = null)
    {
        $this->name = $name;
        $this->rawValue = $value;
        $this->post = $post;

        $this->tryUnserialize($this->rawValue);
    }



    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    public function setPost($post) {
        $this->post = $post;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getValue()
    {
        return $this->value;
    }


    /**
     * @param string $rawValue
     * @return bool
     */
    protected function tryUnserialize($rawValue)
    {
        $errorReporting = ini_get('display_errors');

        ini_set('display_errors', false);
        $value = unserialize($rawValue);
        ini_set('display_errors', $errorReporting);

        if($rawValue !== $value && $value !== false) {
            $this->serialized = true;
            $this->value = $value;
            return true;
        }
        $this->value = $this->rawValue;
        return false;
    }

}
