<?php


class EventGenCollection extends GenCollection
{

    public function targetClass(): string
    {
        return Event::class;
    }
}