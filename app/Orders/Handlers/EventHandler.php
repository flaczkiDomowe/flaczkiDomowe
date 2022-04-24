<?php



class EventHandler extends AbstractRestfulHandler
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
        if (!empty($_GET['docID'])) {
            $arr=$_GET;
            try {
                $id=$this->manager->addSingleEvent($arr);
                $event = $this->manager->getSingeEvent($id);
            } catch (Exception $e) {
                echo "Wystapil problem podczas dodawania nowego zdarzenia";
                http_response_code(500);
            }
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($this->manager->serializeEvent($event));
        } else {
            echo "Brak id zamówienia";
            http_response_code(400);
        }
    }

    public function get($id=0)
    {
        header("Content-Type: application/json");
        if (empty($id))
        {
            $events = $this->manager->getManyEvents($_GET)->getGenerator();
            $serializedEvents = array();
            foreach ($events as $event) {
                $serializedEvents[] = $this->manager->serializeEvent($event);
            }
            http_response_code(200);
            echo json_encode($serializedEvents);
        } else {
            if ($this->manager->eventExist($id)) {
                http_response_code(200);
                echo json_encode($this->manager->serializeEvent($this->manager->getSingeEvent($id)));
            } else {
                echo json_encode([]);
            }
        }

    }

    public function put($id=0)
    {
        $fields=$_GET;
        $fields["ID"]=$id;
        try {
            $this->manager->updateEvent($fields);
            http_response_code(200);
        } catch (Exception $e) {
            echo "Wystapil problem podczas aktualizowania zdarzenia";
            http_response_code(500);
        }
    }

    public function delete($id=0)
    {
        if (!empty($id)) {
            try {
                $this->manager->deleteEvent($id);
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