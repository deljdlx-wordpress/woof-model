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

                echo '<div style="border: solid 2px #F00">';
                    echo '<div style="; background-color:#CCC">@'.__FILE__.' : '.__LINE__.'</div>';
                    echo '<pre style="background-color: rgba(255,255,255, 0.8);">';
                    print_r($data);
                    echo '</pre>';
                echo '</div>';

                $field->loadFromWordpress($data);
                $group['fields'][] = $field;
            }
        }

        return $fieldGroups;
    }



}
