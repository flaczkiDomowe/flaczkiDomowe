<?php
namespace app;

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
                        Name VARCHAR(50) NOT NULL,
                        DateCreated Date NOT NULL,
                        Status TEXT,
                        DateLast TIMESTAMP
                      )");

            $this->conn->exec("CREATE TABLE IF NOT EXISTS status (
                    ID INTEGER PRIMARY KEY,
                    Status TEXT,
                    DateLast TIMESTAMP,
                    docID VARCHAR (255),
                    FOREIGN KEY (project_id)
                    REFERENCES projects(project_id) ON DELETE CASCADE)");
            echo "created success";
        }catch (\Exception $e){
            echo $e;
        }
    }

}