<?php

namespace Woof\Model\Wordpress;

class Database
{


    private static $instance;

    private $wpdb;

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }




    /**
     * Return Wordpress database component
     * @return \wpdb
     */
    public function getWpdb()
    {
        return $this->wpdb;
    }

    /**
     * execute a create table query
     *
     * @param string $sql
     * @return void
     */
    public function executeCreateTableQuery($sql)
    {
        // nous devons un require à la main de cette bibliothèque afin de pouvoir utiliser la fonction dbDelta
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // https://developer.wordpress.org/reference/functions/dbdelta/
        dbDelta($sql);
    }

    public function queryAndFetch($sql, $parameters = [])
    {
        $database = $this->getWpdb();
        $preparedQuery = $database->prepare($sql, $parameters);
        $results = $database->get_results($preparedQuery);
        return $results;
    }

    public function execute($sql, $parameters = null)
    {
        $database = $this->getWpdb();
        if($parameters === null) {
            return $database->query($sql);
        }
        else {
            $preparedQuery = $database->prepare($sql, $parameters);
            return $database->query($preparedQuery);
        }
    }
}
