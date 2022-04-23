<?php

namespace app;

use Exception;

class UndefinedRequestMethodException extends Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->code="123";
        parent::__construct($string);
    }
}