<?php
namespace app;


class OrderRestfulController extends AbstractRestfulController
{
    /**
     * @var OrderManager
     */
    private $manager;
    public function __construct(OrderManager $manager)
    {
        $this->manager=$manager;
    }

    public function create()
    {
        $id=$this->manager->addSingleOrder("GIRAFFE");
        $order=$this->manager->getSingleOrder($id);
        $statusy=["dodano","przerobiono","zakonczono"];
        $this->manager->addSomeEvents($order->getId(),$statusy);
        echo json_encode($this->manager->serializeOrder($order));
    }

    public function read()
    {
        echo "I am reading";
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}