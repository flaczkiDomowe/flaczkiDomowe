<?php

namespace app\Orders\Handlers\Model\Db;
use PDO;

class DbConnection
{

    /**
     * @var PDO
     */
    protected $conn;

    private $dsn, $username, $password;

    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect(/*$username,$password*/)
    {
        $this->conn = new PDO($this->dsn/*,$username,$password*/);
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }



}