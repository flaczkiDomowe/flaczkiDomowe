<?php




class Router
{

    public function start(){
        Toro::serve(array(
            "/" => "MainHandler",
            "/order"=>"OrderHandler",
            "/order/:number" => "OrderHandler",
            "/event/:number" => "EventHandler",
            "/event"=>"EventHandler"
            ));
    }


}