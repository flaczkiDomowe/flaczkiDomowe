<?php
namespace app\Routing;



use Toro;

class Router
{

    public function start(){
        Toro::serve(array(
            "/" => "MainHandler",
            "/order/:number" => "app/OrderHandler",
            "/event/:number" => "app/EventHandler",
        ));
    }


}