<?php
namespace app;

class App
{
    public function start(){
        $boss=new RouterBoss();
        $boss->delegateToMethod();
    }
}