<?php

namespace app\Orders\Handlers\Orders\Collections;

class OrderGenCollection extends GenCollection
{

    public function targetClass(): string
    {
        return Order::class;
    }
}