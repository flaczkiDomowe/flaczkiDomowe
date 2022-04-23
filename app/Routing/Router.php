<?php
namespace app;

use Exception;

class Router
{
    private $routesWithControllers=[];

    public function matchRoute():string{
        $pathArray=explode("/",$_SERVER["REQUEST_URI"]);
        $route="";
        if(sizeof($pathArray)>2){
            $route=$pathArray[2];
        } else {
            $route="index";
        }
        return $route;
    }


}