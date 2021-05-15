<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\User as WordpressUser;

class User extends Manager
{
    protected static $instance;

    protected $items;
    protected $itemsByAttribute = [];

    /**
     * @return WordpressUser[]
     */
    public function loadAll()
    {

        return get_users([
        ]);
    }


    /**
     * get current user
     * @return WordpressUser
     */
    public static function getCurrent()
    {
        $userData = wp_get_current_user();
        $user = new WordpressUser();
        $user->loadFromWordpress($userData);
        return $user;
    }


    /**
     * @param int $id
     * @return WordpressUser
     */
    public static function getById($id)
    {
        return static::getByAttributeValue(
            'id',
            $id,
            function($id) {
                return get_user_by('id', $id);
            }
        );
    }


    // DOC récupération liste  de users https://developer.wordpress.org/reference/functions/get_users/
    /**
     * Rerieve users by role
     *
     * @param string|array $role
     * @param string $orderBy
     * @param string $order
     * @return \Wp_User[]
     */

    /*
    static public function getByRole($role, $orderBy = 'user_nicename', $order = 'ASC')
    {
        if(is_string($role)) {
            $args = array(
                'role'    => $role,
                'orderby' => $orderBy,
                'order'   => $order
            );
        }
        elseif(is_array($role)) {
            $args = array(
                'role__in'    => $role,
                'orderby' => $orderBy,
                'order'   => $order
            );
        }
        else {
            throw new \Exception('$role parameter must be a string or an array. Passed value : ' . print_r($role, true));
        }
        $wpUsers =  get_users( $args );

        $users = [];
        foreach($wpUsers as $wpUser) {
            $wpUsers[] = static::getFromWordpressUser($wpUser);
        }

        return $users;
    }

    */


}