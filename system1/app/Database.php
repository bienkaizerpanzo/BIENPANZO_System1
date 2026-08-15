<?php

class Database
{
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private string $charset;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';

        $this->host = $config['host'];
        $this->dbName = $config['dbname'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->charset = $config['charset'];
    }

    public function getConnection(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $this->host,
            $this->dbName,
            $this->charset
        );

        try {
            $pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            return $pdo;
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed. Please try again later.');
        }
    }
}
