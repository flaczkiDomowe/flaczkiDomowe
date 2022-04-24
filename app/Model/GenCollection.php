<?php


abstract class GenCollection
{
    protected $mapper;
    protected $total = 0;
    protected $raw = [];
    private $objects = [];

    public function __construct(array $raw = [], AbstractMapper $mapper = null)
    {
        $this->raw = $raw;
        $this->total = count($raw);
        if (count($raw) && is_null($mapper)) {
            throw new Exception("do generowania obiektów potrzebny jest obiekt Mapper");
        }
        $this->mapper = $mapper;
    }
    public function add(AbstractDomainObject $object)
    {
        $class = $this->targetClass();
        if (! ($object instanceof $class )) {
            throw new InvalidArgumentException("To jest kolekcja {$class}");
        }
        $this->objects[$this->total] = $object;
        $this->total++;
    }
    public function getGenerator(): \Generator
    {
        for ($x = 0; $x < $this->total; $x++) {
            yield $this->getRow($x);
        }
    }
    abstract public function targetClass(): string;

    private function getRow($num)
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }
        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }
        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->mapper->createObject($this->raw[$num]);

         return $this->objects[$num];
         }
    }

}