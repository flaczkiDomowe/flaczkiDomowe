<?php

namespace app;

class OrderGenCollection extends GenCollection
{

    public function targetClass(): string
    {
        return Order::class;
    }
}