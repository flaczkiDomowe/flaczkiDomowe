<?php
namespace app;
class App
{
    public function start(){
        $service=new AuthenticationService();
        $conn=new SQLiteConnection($service,"a","b");
    }
}