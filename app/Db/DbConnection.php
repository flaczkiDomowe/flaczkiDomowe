<?php

namespace app;

use PDO;

class DbConnection
{
    protected $conn;
    private $dsn, $username, $password;

    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new PDO($this->dsn);
    }


}