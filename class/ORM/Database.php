<?php

namespace Woof\Model\ORM;

use Illuminate\Database\Capsule\Manager;
use Woof\Model\Wordpress\Database as WordpressDatabase;

class Database
{
    public static $prefix;


    /**
     * Eloquent manager
     * @var Manager
     */

    private $driver;


    /**
     * Wordpress database access
     *
     * @var WordpressDatabase
     */
    private $wordpressDriver;

    public function __construct()
    {
        $this->wordpressDriver = WordpressDatabase::getInstance();

        static::$prefix = $this->wordpressDriver->getWpdb()->prefix;

        $this->driver = new Manager();

        // IMPORTANT eloquent initialization
        $this->driver->addConnection(
            [
                'driver' => 'mysql',
                'host' => \DB_HOST,
                'database' => \DB_NAME,
                'username' => \DB_USER,
                'password' => \DB_PASSWORD,
                'charset' => $this->wordpressDriver->getWpdb()->charset,
                // 'prefix' => $this->wordpressDriver->prefix
                //'collation' => $this->wordpressDriver->collate,

            ],
            'default'
        );

        $this->driver->setAsGlobal();
        $this->driver->bootEloquent();

        /*
        $this->driver->schema()->create('bllooo', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('userimage')->nullable();
            $table->string('api_key')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
        });
        */
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getWordpressDriver()
    {
        return $this->wordpressDriver;
    }
}
