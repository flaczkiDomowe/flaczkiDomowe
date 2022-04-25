<?php



class ValidationUtilities extends AbstractUtilities
{

    public static function isInteger($input):bool{
    return(ctype_digit(strval($input)));
}
}