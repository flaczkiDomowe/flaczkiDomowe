<?php

namespace app;

class ValidationUtilities
{

    public static function isInteger($input):bool{
    return(ctype_digit(strval($input)));
}
}