<?php

use App\Models\Auth\User;

return [

    /**
     * name of application
     */
    'appName' => $_ENV['APP_NAME'],

    /**
     * url of the application
     */
    'appURL' => $_ENV['APP_URL'],

    /**
     * port of application
     */
    'appPORT' => $_ENV['APP_PORT'],

    /**
     * Model used for authentication
     */
    'authClassName' => User::class,

    /**
     * Load credentials for database from .env file
     */
    'db' => [
        'type' => $_ENV['DB_TYPE'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];
