<?php

namespace Woof\Model\Wordpress\Manager;

use Woof\Model\Wordpress\User as WordpressUser;

class User extends Manager
{
    protected static $instance;

    protected $items;

    /**
     * @return WordpressUser[]
     */
    public function loadAll()
    {
        $this->items = [];

        $data = get_users([

        ]);

        foreach($data as $userData) {

            $user = new WordpressUser();
            $user->loadFromWordpress($userData);

            $this->items[$user->getId()] = $user;
        }

        return $this->items;
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

        $instance = static::getInstance();

        if(isset($instance->userById[$id])) {
            return $instance->userById[$id];
        }


        $userData = get_user_by('id', $id);
        $user = new WordpressUser();
        $user->loadFromWordpress($userData);
        $instance->userById[$user->getId()] = $user;
        return $user;
    }






     /*
    static public function getByIds(array $userIds)
    {
        $wpUsers = get_users([
            'include' => $userIds
        ]);

        $users = [];
        foreach($wpUsers as $wpUser) {
            $users[] = static::getFromWordpressUser($wpUser);
        }
        return $users;
    }
    */




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