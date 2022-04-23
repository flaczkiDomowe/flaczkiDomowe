<?php
namespace app;
abstract class AbstractRestfulController extends AbstractController
{
    abstract public function create();
    abstract public function read();
    abstract public function update();
    abstract public function delete();
}