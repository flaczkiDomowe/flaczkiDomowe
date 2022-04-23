<?php
namespace app;
class ControllerFactory
{
    public static function get($name)
    {
        switch($name){
            case "order":
              return ControllerFactory::getOrderRestfulController();
            break;
            default:
                return ControllerFactory::getMainController();
                break;
        }
    }
    private static function getOrderRestfulController():OrderRestfulController
    {
        $service=new AuthenticationService();
        $conn=new SQLiteConnection($service,"a","b");
        $manager=new OrderManager(new OrderMapper($conn),new EventMapper($conn));
        return new OrderRestfulController($manager);
    }

    private static function getMainController()
    {
        return new MainController();
    }
}