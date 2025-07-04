<?php

namespace Thales\EmissorNF\config\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $conn = null;

    public static function connect(): PDO
    {
        if (self::$conn === null) {
            $host = 'db';
            $dbname = 'emissornfdb';
            $user = 'postgres';
            $pass = 'postgres';

            try {
                self::$conn = new PDO("pgsql:host={$host};dbname={$dbname}", $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new PDOException("Erro ao conectar com o banco: " . $e->getMessage());
            }
        }

        return self::$conn;
    }

    public static function disconnect(): void
    {
        self::$conn = null;
    }
}
