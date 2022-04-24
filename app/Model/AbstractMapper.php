<?php
namespace app;
use Exception;
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
    public function createObject(array $fields):AbstractDomainObject{
        $this->validate($fields);
        return $this->doCreateObject($fields);
    }
    abstract protected function doCreateObject(array $fields):AbstractDomainObject;
    abstract protected function validateFields(array $fields);
    protected function validate(array $fields){
        $this->validateID($fields);
        $this->validateFields($fields);
    }
    private function validateID($fields){
        foreach($fields as $key=>$val){
            if(strtoupper($key)==="ID"){
                try{
                if(ValidationUtilities::isInteger($val)&&intval($val)>0){
                    return;
                }else {
                    throw new Exception();
                }
            } catch(Exception $e){
                throw new InvalidArgumentException("Niepoprawne ID");
                }
            }
        }
    }

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