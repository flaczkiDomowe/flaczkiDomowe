<?php
namespace app;
use DateTimeImmutable;
use Iterator;
use Traversable;



class EventMapper extends AbstractMapper
{
    const TABLENAME="events";
    public function __construct(DbConnection $conn)
    {

        parent::__construct($conn);
    }

    public function findByID(int $id): AbstractDomainObject
    {
        $tableName=self::TABLENAME;
        $sql="SELECT ID,Status,Date,docID FROM $tableName WHERE ID=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $row=$stmt->fetch($this->conn::FETCH_ASSOC);
        $order=$this->createObject($row);
        return $order;
    }


    public function findOrderEvents(Order $order):Order{
        $orderId=$order->getId();
        $condition="WHERE docId=?";
        $events=$this->findAll($condition,[$orderId]);
        /** @var EventGenCollection $events */
        $order->setEvents($events);
        return $order;
    }

    public function findAll(string $condition, array $arguments): GenCollection
    {

        $tableName=self::TABLENAME;
        $sql="SELECT ID,Status,Date,docID FROM $tableName ";
        $sql.=$condition;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($arguments);
        $rows=$stmt->fetchAll($this->conn::FETCH_ASSOC);
        $collection=new EventGenCollection($rows,$this);
        return $collection;
    }


    public function createObject(array $fields): AbstractDomainObject
    {
        $status=new Event();
        $filteredNullsFields=array_filter($fields);
        foreach($filteredNullsFields as $key=>$val){
            switch(strtoupper($key)){
                case "ID":
                    $status->setId($val);
                    break;
                case "STATUS":
                    $status->setStatus($val);
                    break;
                case "DATE":
                    $date=DateTimeImmutable::createFromFormat(Event::DATE_FORMAT,$val);
                    $status->setDate($date);
                    break;
                case "DOCID":
                    $status->setDocId($val);
                    break;

            }
        }
        return $status;
    }

    /**
     * @param Event $obj
     * @return int
     */
    protected function doInsert($obj): int
    {
        $tableName=$this::TABLENAME;
        $dateTime=TimeUtilities::getFormattedToday(Event::DATE_FORMAT);
        $status=$obj->getStatus();
        $docId=$obj->getDocId();
        $sql="INSERT INTO $tableName (Status,Date,docID) VALUES(?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $dateTime,$docId]);
        return $this->conn->lastInsertId();
    }

    /**
     * @param Event $obj
     * @return string
     */
    protected function doUpdate($obj)
    {
        $tableName=$this::TABLENAME;
        $id=$obj->getId();
        $status=$obj->getStatus();
        $date=$obj->getDateString();
        $docId=$obj->getDocId();
        $sql="UPDATE $tableName SET Status=?,Date=?,DocID=? WHERE ID=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $date,$docId,$id]);
    }


}