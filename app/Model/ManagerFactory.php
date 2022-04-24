<?php


class ManagerFactory
{
    public static function get($name){
        switch($name) {
            case OrderManager::class:
            $manager=ManagerFactory::createOrderManager();
           break;
            default:
                $manager=ManagerFactory::createOrderManager();
                break;
        }
        return $manager;
    }
    private static function createOrderManager():OrderManager{
        $auth = new AuthenticationService();
        $conn = new SQLiteConnection($auth, "username", "passwd");
        $orderMapper = new OrderMapper($conn);
        $eventMapper=new EventMapper($conn);
        return new OrderManager($orderMapper,$eventMapper);
    }
}