<?php
$host = "localhost";
$user = "DB_USER";
$password = "DB_PASSWORD";
$database = "DB_NAME";

function get_db_connection(): ?PDO
{
    global $host, $user, $password, $database;

    try {
        $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $pdo;
    } catch (PDOException $exception) {
        return null;
    }
}
