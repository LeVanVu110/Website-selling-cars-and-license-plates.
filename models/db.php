<?php
class Db
{
    public static $connection;

    public function __construct()
    {
        self::getConnection();
    }

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
            if (self::$connection->connect_error) {
                die("Kết nối thất bại: " . self::$connection->connect_error);
            }
            self::$connection->set_charset(DB_CHARSET);
        }
        return self::$connection;
    }
}
