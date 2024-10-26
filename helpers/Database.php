<?php


class Database
{
    private static $_pdo;

    public static function getInstance()
    {
        if (is_null(self::$_pdo)) {
            self::$_pdo = new PDO(DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$_pdo;
    }
}
