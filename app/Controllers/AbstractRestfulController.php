<?php
namespace app;
abstract class AbstractRestfulController extends AbstractController
{
    public function parseInput()
    {
        $data = file_get_contents("php://input");

        if($data == false)
            return array();

        parse_str($data, $result);

        return $result;
    }
    abstract public function create();
    abstract public function read();
    abstract public function update();
    abstract public function delete();
}