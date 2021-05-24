<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\ACFField;

class ACFFieldGroup extends Manager
{
    // protected static $instance;

    protected $items;
    protected $itemsByAttribute = [];

    public function loadAll()
    {
        $fieldGroups = acf_get_field_groups();

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
                $field = new ACFField();
                $field->loadFromWordpress($data);
                $group['fields'][] = $field;
            }
        }

        return $fieldGroups;
    }



}
