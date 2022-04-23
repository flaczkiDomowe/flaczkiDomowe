<?php
namespace app;
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
    public function getSingleOrder($id):Order{
        $order= $this->orderMapper->findByID($id);
        $order->setName("NOT GIRAFFE");
        $this->orderMapper->update($order);
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
}