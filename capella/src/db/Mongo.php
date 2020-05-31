<?php

namespace App\DB;

/**
 * Class statically creates an instance of the mongo database.
 *
 * @package utils
 * @subpackage mongodb
 *
 * @link https://github.com/calebjonasson/mongodb-php-singleton
 */
class Mongo
{
    private static $_connection;
    private static $_instance;

    /**
     * Make these magic methods private as it should be instanciated through the connect method.
     * Ie: Mongo::connect();
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Method will instantiate the object and create a mongo client.
     * Return value will change depending on the $database parameter.
     *
     * @param String $database the database to auto connect to.
     *
     * @return \MongoDB\Client|\MongoDB\Database. Either the database object or the MongoDB\Client object.
     */
    public static function connect($database = 'capella')
    {
        /**
         * Establish a new static object.
         */
        if (!isset(self::$_instance)) {
            self::$_instance = new Mongo();
        }

        /**
         * Check to make sure that we have an object.
         */
        if (!isset(self::$_connection)) {
            $domain = \Env::get('MONGO_HOST') ?? 'mongo';
            $port = \Env::get('MONGO_PORT') ?? 27017;

            self::$_connection = new \MongoDB\Client(
                "mongodb://{$domain}:{$port}", [],
                [
                    'typeMap' => [
                        'array' => 'array',
                        'document' => 'array',
                        'root' => 'array',
                    ],
                ]
            );
        }

        /**
         * Check to see if the database string is empty. If so return the object instance.
         */
        if (!empty($database) && is_string($database)) {
            $database = \Env::get('MONGO_DBNAME') ?? $database;

            $connectedDatabase = self::$_connection->$database;

            return $connectedDatabase;
        }

        return self::$_connection;
    }
}