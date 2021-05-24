<?php

namespace Woof\Model\Wordpress\Traits;


trait Acf
{
    public function getAcfFields($postId, $formatValue = true)
    {
        return get_fields($postId, $formatValue);
    }
}
