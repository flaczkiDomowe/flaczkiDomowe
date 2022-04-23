<?php
namespace app;
use InvalidArgumentException;
use Iterator;

abstract class AbstractMapper
{

    /**
     * @var DbConnection
     */
    protected $conn;

    public function __construct(DbConnection $conn)
    {
        $this->conn=$conn->getConnection();
    }

    abstract public function findByID(int $id):AbstractDomainObject;
    abstract public function findAll(string $condition,array $arguments):GenCollection;
    abstract public function createObject(array $fields):AbstractDomainObject;
    public function insert($obj):int{
        if(is_subclass_of($obj,AbstractDomainObject::class)){
            $result=$this->doInsert($obj);
        } else {
            $class=AbstractDomainObject::class;
            $objClass=get_class($obj);
            throw new InvalidArgumentException("Expected object of subtype $class, got $objClass");
        };
        return $result;
    }
    public function update($obj){
        if(is_subclass_of($obj,AbstractDomainObject::class)){
            $this->doUpdate($obj);
        } else {
            $class=AbstractDomainObject::class;
            $objClass=get_class($obj);
            throw new InvalidArgumentException("Expected object of subtype $class, got $objClass");
        }
    }
    abstract protected function doInsert($obj):int;
    abstract protected function doUpdate($obj);


}