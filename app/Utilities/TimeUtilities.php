<?php
namespace app\Utilities;
class TimeUtilities
{


    public static function getFormattedToday(string $format):string
    {
        $today=new \DateTimeImmutable("now");
        return $today->format($format);
    }
}