<?php
namespace app\Orders\Handlers\Model\Handlers;
abstract class AbstractRestfulHandler extends AbstractHandler
{
    abstract public function get($id);
    abstract public function post();
    abstract public function put();
    abstract public function delete($id);
}