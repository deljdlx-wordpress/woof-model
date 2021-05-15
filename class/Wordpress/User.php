<?php


namespace Woof\Model\Wordpress;


class User extends Entity
{

    public $ID;

    public $data = null;
    /*stdClass
        'ID' => null,
        'user_login' => null,
        'user_pass' => null,
        'user_nicename' => null,
        'user_email' => null,
        'user_url' => null,
        'user_registered' => null,
        'user_activation_key' => null,
        'user_status' => null,
        'display_name' => null
    */

    public $caps = [];
    public $roles = [];
    public $allcaps = [];
    public $filter = null;


    protected $roleInstances = null;




    public function getId()
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->data->user_login;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->data->display_name;
    }

    /**
     * Alias of getDisplayName()
     *
     * @return string
     */
    public function getName()
    {
        return $this->getDisplayName();
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->data->user_email;
    }


    public function getRoles()
    {

        if($this->roleInstances === null) {
            $this->roleInstances = [];

            foreach($this->roles as $roleName) {
                $role = new Role();
                $role->loadByName($roleName);
                $this->roleInstances[$roleName] = $role;
            }
        }
        return $this->roleInstances;
    }

    /**
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if(in_array($role, $this->roles)) {
            return true;
        }
        return false;
    }


    /**
     *
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        $this->getWordpress()->add_role($role);
        return $this;
    }



    // ==========================================================================
    public function getMetadata($name, $single = true)
    {
        return get_user_meta(
            $this->getId(),
            $name,
            $single
        );
    }

    // ==========================================================================


    /**
     * @param int $id
     * @return $this
     */
    public function loadById($id)
    {
        $wpUser = get_user_by('id', $id);
        $this->loadFromWordpress($wpUser);
        return $this;
    }




}