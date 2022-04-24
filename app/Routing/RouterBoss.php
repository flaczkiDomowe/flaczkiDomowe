<?php

namespace app;

class RouterBoss
{
    /**
     * @var Router
     */
    private $router;
    private $restMap=[
        "POST"=>"create",
        "GET"=>"read",
        "PUT"=>"update",
        "DELETE"=>"delete"
    ];
    public function __construct()
    {
        $this->router=new Router();
    }

    public function delegateToMethod()
    {
        $route=$this->router->matchRoute();
        $deleteQuery=explode("?",$route)[0];
        $controller=ControllerFactory::get($deleteQuery);
        if(is_subclass_of($controller,AbstractRestfulController::class)){
            $method=$this->restDelegation();
            $controller->$method();
        } else {
            $controller->indexAction();
        }
    }
    private function restDelegation(){
        if(array_key_exists($_SERVER["REQUEST_METHOD"],$this->restMap)){
            return $this->restMap[$_SERVER["REQUEST_METHOD"]];
        } else {
            throw new UndefinedRequestMethodException("Nie zidentyfikowana metoda");
        }
    }
}