<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\ACFField as WordpressACFField;

class ACFField extends Manager
{
    protected static $instance;

    protected $items;
    protected $itemsByAttribute = [];

    public function loadAll()
    {
        $fieldGroups = acf_get_field_groups();
        $fields = [];

        foreach ($fieldGroups as &$group) {
            $fields = get_posts(array(
                'posts_per_page'   => -1,
                'post_type'        => 'acf-field',
                'orderby'          => 'menu_order',
                'order'            => 'ASC',
                'suppress_filters' => true, // DO NOT allow WPML to modify the query
                'post_parent'      => $group['ID'],
                'post_status'      => 'any',
                'update_post_meta_cache' => false
            ));

            foreach($fields as $data) {
                $field = new WordpressACFField();
                $field->loadFromWordpress($data);
                $fields[] = $field;
            }
        }
        return $fields;
    }
}
