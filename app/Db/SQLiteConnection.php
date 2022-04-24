<?php
namespace app\Orders\Handlers\Model\Db;
use app\Orders\Handlers\Model\Authentication\Orders\Handlers\Model\Utilities\Utilities\Orders\Orders\Mappers\Orders\Mappers\Orders\Handlers\Orders\Handlers\Orders\Handlers\Orders\DomainObjects\Orders\DomainObjects\Orders\Collections\Orders\Collections\Model\Model\Model\Model\Handlers\Handlers\Db\Db\Authentication\Routing\Config;
use PDO;

class SQLiteConnection extends DbConnection
{
    public function __construct(AuthenticationService $auth,$username, $password)
    {
        $dsn="sqlite:" . Config::SQLITE_PATH;
        if($auth->authenticate($username,$password)) {
            parent::__construct($dsn, $username, $password);
        } else {
            parent::__construct($dsn,Config::SQLITE_GUEST_USERNAME,Config::SQLITE_GUEST_PASSWORD);
        }
    }

    public function setUp(){
        try {
            $this->conn->exec("CREATE TABLE IF NOT EXISTS documents (
                        ID   INTEGER PRIMARY KEY,
                        Name TEXT NOT NULL,
                        DateCreated TEXT NOT NULL,
                        Event TEXT,
                        DateLast TEXT 
                      )");

            $this->conn->exec("CREATE TABLE IF NOT EXISTS statuses (
                    ID INTEGER PRIMARY KEY,
                    Event TEXT NOT NULL,
                    Date TEXT NOT NULL,
                    docID INTEGER,
                    FOREIGN KEY (docID)
                    REFERENCES documents(docID) ON DELETE CASCADE)");
        }catch (\Exception $e){
            die($e);
        }
    }
    public function printTables(){
        $sql = "SELECT  `name` FROM sqlite_master WHERE `type`='table'  ORDER BY name";
        $result = $this->conn->query($sql);
        if($result){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                echo '<li>'.$row['name'].'</li>';
            }
        }
    }

}