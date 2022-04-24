<?php
namespace app;


class OrderRestfulController extends AbstractRestfulController
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
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $id = $this->manager->addSingleOrder($name);
            $order = $this->manager->getSingleOrder($id);
            echo json_encode($this->manager->serializeOrder($order));
        } else {

        }
        }

    public function read()
    {
        echo "I am reading";
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