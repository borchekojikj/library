<?php

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
        } catch (\PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query($query)
    {
        return $this->conn->query($query);
    }

    public function prepare($query)
    {
        return $this->conn->prepare($query);
    }
}
