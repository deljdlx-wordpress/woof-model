<?php

namespace Woof\Model\Wordpress;


class ACFField extends Post
{

    public function getName()
    {
        return $this->post_excerpt;
    }
}

