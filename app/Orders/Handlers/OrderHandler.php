<?php

namespace app\Orders\Handlers;


use Exception;

class OrderHandler extends AbstractRestfulHandler
{
    /**
     * @var OrderManager
     */
    private $manager;

    public function __construct()
    {
        $this->manager=ManagerFactory::get(OrderManager::class);
    }

    public function post()
    {
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            try {
                $id = $this->manager->addSingleOrder($name);
                $order = $this->manager->getSingleOrder($id);
            } catch (Exception $e) {
                echo "Wystapil problem podczas dodawania nowego zamówienia";
                http_response_code(500);
            }
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($this->manager->serializeOrder($order));
        } else {
            echo "Brak zdefiniowanej nazwy zamówienia";
            http_response_code(400);
        }
    }

    public function get($id)
    {
        header("Content-Type: application/json");
        if (empty($_GET['id']))
            {
                if (!empty($_GET['withHistory']) && $_GET['withHistory'] === 'true') {
                    $orders = $this->manager->getManyOrdersWithHistory($_GET)->getGenerator();
                } else {
                    $orders = $this->manager->getManyOrders($_GET)->getGenerator();
                }
                $serializedOrders = array();
                foreach ($orders as $order) {
                    $serializedOrders[] = $this->manager->serializeOrder($order);
                }
                http_response_code(200);
                echo json_encode($serializedOrders);
            } else {
                if ($this->manager->orderExist($_GET['id'])) {
                    http_response_code(200);
                    echo json_encode($this->manager->serializeOrder($this->manager->getSingleOrder($_GET['id'])));
                } else {
                    echo json_encode([]);
                }
            }

        }

    public function put()
    {
        $fields=$_GET;
            try {
                $this->manager->updateOrder($fields);
                http_response_code(200);
            } catch (Exception $e) {
                echo "Wystapil problem podczas aktualizowania zamówienia";
                http_response_code(500);
            }
    }

    public function delete($id)
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $this->manager->deleteOrder($id);
                http_response_code(200);
            } catch (Exception $e) {
                echo "Wystapil problem podczas usuwania zamówienia";
                http_response_code(500);
            }
        } else {
            echo "Brak id zamówienia";
            http_response_code(400);
        }
    }
}