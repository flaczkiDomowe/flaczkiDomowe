<?php
namespace app;
class TimeUtilities
{


    public static function getFormattedToday(string $format):string
    {
        $today=new \DateTimeImmutable("now");
        return $today->format($format);
    }
}