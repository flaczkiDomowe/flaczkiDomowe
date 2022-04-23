<?php
namespace app;

class EventGenCollection extends GenCollection
{

    public function targetClass(): string
    {
        return Event::class;
    }
}