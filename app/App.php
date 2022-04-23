<?php
namespace app;

class App
{
    public function start(){
        $service=new AuthenticationService();
        $conn=new SQLiteConnection($service,"a","b");
        $manager=new OrderManager(new OrderMapper($conn),new EventMapper($conn));
        $id=$manager->addSingleOrder("GIRAFFE");
        $order=$manager->getSingleOrder($id);
        $statusy=["dodano","przerobiono","zakonczono"];
        $manager->addSomeEvents($order->getId(),$statusy);
        echo json_encode($manager->serializeOrder($order));
    }
}