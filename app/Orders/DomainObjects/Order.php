<?php

class Order extends AbstractDomainObject
{
    const DATECREATED_FORMAT="Y-m-d";
    const DATELAST_FORMAT="Y-m-d\TH:i:s";
    /**
     * @var string
     */
    private $name="";

    /**
     * @var DateTimeImmutable
     */
    private $dateCreated;

    /**
     * @var string
     */
    private $status="";

    /**
     * @var DateTimeImmutable
     */
    private $dateLast;

    /**
     * @var EventGenCollection
     */
    private $events;



    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function getDateCreatedString():string
    {

        if(is_a($this->dateCreated,DateTimeImmutable::class)) {
            return $this->dateCreated->format(self::DATECREATED_FORMAT);
        } else {
            return "";
        }
    }

    /**
     * @param DateTimeImmutable $dateCreated
     */
    public function setDateCreated(DateTimeImmutable $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateLast(): DateTimeImmutable
    {
        return $this->dateLast;
    }

    /**
     * @param DateTimeImmutable $dateLast
     */
    public function setDateLast(DateTimeImmutable $dateLast)
    {
        $this->dateLast = $dateLast;
    }

    /**
     * @return EventGenCollection
     */
    public function getEvents(): EventGenCollection
    {
        return $this->events;
    }

    public function setEvents(EventGenCollection $statuses)
    {
        $this->events = $statuses;
    }

    public function getDateLastString():string
    {
        if(is_a($this->dateLast,DateTimeImmutable::class)) {
            return $this->dateLast->format(self::DATELAST_FORMAT);
        } else {
            return "";
        }
    }

    public function serialize():array
    {
        $history=array();
        foreach($this->getEvents()->getGenerator() as $event){
            $history[]=$event->serialize();
        }
        $orderArr=[
            "ID"=>$this->getId(),
            "Name"=>$this->getName(),
            "DateCreated"=>$this->getDateCreatedString(),
            "Status"=>$this->getStatus(),
            "DateLast"=>$this->getDateLastString(),
            "History"=>$history
        ];
        return $orderArr;
    }

    public function unserialize($data)
    {
      $array=json_decode(json_encode(['dwa ziemniaki']));
    }
}