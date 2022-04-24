<?php
namespace app\Orders\Handlers\Orders\DomainObjects;

use app\Orders\Handlers\Model\AbstractDomainObject;
use DateTimeImmutable;

class Event extends AbstractDomainObject
{

    const DATE_FORMAT="Y-m-d\TH:i:s";

    /**
     * @var string
     */
    private $status;

    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * @var int
     */
    private $docId;


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
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function setDate(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getDocId(): int
    {
        return $this->docId;
    }

    /**
     * @param int $docId
     */
    public function setDocId(int $docId)
    {
        $this->docId = $docId;
    }

    public function getDateString()
    {
        if(is_a($this->date,DateTimeImmutable::class)) {
            return $this->date->format(self::DATE_FORMAT);
        } else {
            return "";
        }
    }


    public function serialize(): array
    {

        return[
            "ID"=>$this->getId(),
            "DocID"=>$this->getDocId(),
            "Status"=>$this->getStatus(),
            "Date"=>$this->getDateString()
        ];
    }

    public function unserialize($data)
    {
        $array=json_decode(json_encode(['dwa ziemniaki']));
    }
}