<?php
namespace app;


class App
{
    public function start(){
        $boss=new Router();
        $boss->start();
    }
}