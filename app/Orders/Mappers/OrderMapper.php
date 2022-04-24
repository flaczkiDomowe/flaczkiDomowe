<?php
namespace app;
use DateTimeImmutable;
use Iterator;

class OrderMapper extends AbstractMapper
{
    const TABLENAME="documents";

    public function __construct(DbConnection $conn)
    {
        parent::__construct($conn);
    }

    public function findByID(int $id): AbstractDomainObject
    {
        $tableName=self::TABLENAME;
        $sql="SELECT ID,Name,DateCreated,Status,DateLast FROM $tableName WHERE ID=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $row=$stmt->fetch($this->conn::FETCH_ASSOC);
        $order=$this->createObject($row);
        return $order;
    }

    public function findAll(string $condition,array $arguments):GenCollection
    {
        $tableName=self::TABLENAME;
        $sql="SELECT ID,Name,DateCreated,Event,DateLast FROM $tableName ";
        $sql.=$condition;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($arguments);
        $rows=$stmt->fetchAll($this->conn::FETCH_ASSOC);
        $collection=new OrderGenCollection($rows,$this);
        return $collection;
    }

    protected function doCreateObject(array $fields): AbstractDomainObject
    {
        $order=new Order();
        $filteredNullsFields=array_filter($fields);
        foreach($filteredNullsFields as $key=>$val){
            switch(strtoupper($key)){
               case "ID":
                   $order->setId($val);
                   break;
                case "NAME":
                    $order->setName($val);
                    break;
                case "DATECREATED":
                    $date=DateTimeImmutable::createFromFormat(Order::DATECREATED_FORMAT,$val);
                    $order->setDateCreated($date);
                    break;
                case "STATUS":
                    $order->setStatus($val);
                    break;
                case "DATELAST":
                    $date=DateTimeImmutable::createFromFormat(Order::DATELAST_FORMAT,$val);
                    $order->setDateLast($date);
                    break;

            }
        }
        return $order;
    }

    /**
     * @param Order $obj
     * @return int
     */
    protected function doInsert($obj): int
    {
        $tableName=$this::TABLENAME;
        $dateCreated=TimeUtilities::getFormattedToday('Y-m-d');
        $name=$obj->getName();
        $status=$obj->getStatus();
        $dateLast=$obj->getDateLastString();
        $sql="INSERT INTO $tableName (Name,DateCreated,Status,DateLast) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $dateCreated, $status, $dateLast]);
        return $this->conn->lastInsertId();
    }

    /**
     * @param Order $obj
     * @return string
     */
    protected function doUpdate($obj)
    {
        $tableName=$this::TABLENAME;
        $dateCreated=$obj->getDateCreatedString();
        $dateLast=$obj->getDateLastString();
        $status=$obj->getStatus();
        $name=$obj->getName();
        $id=$obj->getId();
        $sql="UPDATE $tableName SET Name=?,DateCreated=?,Status=?,DateLast=? WHERE ID=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $dateCreated,$status,$dateLast,$id]);
    }

    //todo:: dodać walidację pól
    protected function validateFields(array $fields)
    {
       return;
    }
}