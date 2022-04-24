<?php

namespace app\Orders\Handlers;

class EventHandler extends AbstractRestfulHandler
{

    /**
     * @var OrderManager
     */
    private $manager;

    public function __construct(OrderManager $manager)
    {
        $this->manager=$manager;
    }
    public function create()
    {
        // TODO: Implement create() method.
    }

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}