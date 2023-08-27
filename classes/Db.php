<?php

class Db
{

    private static $db; // The database connection

    public static function getInstance()
    { // Get an instance of the Database

        if (self::$db !== null) { // Connection already established, reuse it

            return self::$db;
        } else { // Create a new connections

            $dsn = 'mysql:host=ID392023_portpixel.db.webhosting.be;dbname=ID392023_portpixel'; // Data Source Name
            $username = 'ID392023_portpixel';
            $password = 'dkWX-KWt3sr!Rk7';

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays
                PDO::ATTR_EMULATE_PREPARES => false, // Use real prepared statements
            ];

            self::$db = new PDO($dsn, $username, $password, $options); // Create a new PDO connection
            return self::$db; // Return the connection
        }
    }
}