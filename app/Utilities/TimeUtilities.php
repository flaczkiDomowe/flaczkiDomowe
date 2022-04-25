<?php


class TimeUtilities extends AbstractUtilities
{


    public static function getFormattedToday(string $format):string
    {
        $today=new DateTimeImmutable("now");
        return $today->format($format);
    }
}