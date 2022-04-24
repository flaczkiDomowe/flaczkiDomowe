<?php
namespace app\Orders\Handlers\Orders\Collections;
use app\Orders\Handlers\Model\GenCollection;

class EventGenCollection extends GenCollection
{

    public function targetClass(): string
    {
        return Event::class;
    }
}