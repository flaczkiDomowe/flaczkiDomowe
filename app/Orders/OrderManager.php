<?php


class OrderManager
{
    /**
     * @var OrderMapper
     */
    private $orderMapper;
    private $eventMapper;

    public function __construct(OrderMapper $orderMapper, EventMapper $eventMapper)
    {
        $this->orderMapper=$orderMapper;
        $this->eventMapper=$eventMapper;
    }

    public function addSingleOrder(string $name){
        $order=$this->orderMapper->createObject(['name'=>$name]);
        $id=$this->orderMapper->insert($order);
        return $id;
    }

    public function orderExist($id){
        return $this->orderMapper->exists($id);
    }
    public function eventExist($id){
        return $this->eventMapper->exists($id);
    }

    public function getSingleOrder($id):Order{
        $order= $this->orderMapper->findByID($id);
        return $order;
    }

    public function addSomeEvents($docId,array $events){
        foreach ($events as $eventStatus){
            $event=$this->eventMapper->createObject(["status"=>$eventStatus,"docId"=>$docId]);
            $this->eventMapper->insert($event);
        }
    }
    public function serializeOrder(Order $order){
        $orderWithEvents=$this->eventMapper->findOrderEvents($order);
        return $orderWithEvents->serialize();
    }

    public function getManyOrders(array $userConditions)
    {
        $condArr=$this->generateCondition($userConditions);
        return $this->orderMapper->findAll($condArr[0],$condArr[1]);
    }

    public function getManyOrdersWithHistory(array $userConditions){
        $orders=$this->getManyOrders($userConditions);
        $ordersWithHistory=new OrderGenCollection();
        foreach ($orders->getGenerator() as $order){
           $ordersWithHistory->add($this->eventMapper->findOrderEvents($order));
        }
        return $ordersWithHistory;
    }

    private function generateCondition(array $conditions){
        $sql="WHERE ";
        $cond=[];
        $it=0;
        foreach($conditions as $key=>$val){
            if(in_array(strtoupper($key),OrderMapper::validFields)){
                if($it===0) {
                    $sql .= "$key=?";
                    $cond[] = $val;
                } else {
                    $sql.=" AND $key=?";
                    $cond[]=$val;
                }
                $it++;
            }
        }
        if($it===0){
            $sql="";
        }
        return [$sql,$cond];
    }

    public function deleteOrder($id)
    {
        $this->orderMapper->delete($id);
    }

    public function updateOrder(array $fields)
    {
        $order=$this->orderMapper->createObject($fields,true);
        $this->orderMapper->update($order);
    }

    public function addSingleEvent(array $arr):int
    {
        if($this->orderMapper->exists($arr["docID"])){
            $ev=$this->eventMapper->createObject($arr);
           $id= $this->eventMapper->insert($ev);
        } else {
            throw new InvalidArgumentException();
        }
        return $id;
    }

    public function getSingeEvent(int $id):Event
    {
       return $this->eventMapper->findByID($id);
    }

    public function getManyEvents(array $userConditions)
    {
        $condArr=$this->generateCondition($userConditions);
        return $this->eventMapper->findAll($condArr[0],$condArr[1]);
    }

    public function serializeEvent($event)
    {
        return $event->serialize();
    }

    public function updateEvent(array $fields)
    {
        $event=$this->eventMapper->createObject($fields,true);
        $this->eventMapper->update($event);
    }

    public function deleteEvent($id)
    {
        $this->eventMapper->delete($id);
    }

}