<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderOrderItem extends OrderSub
{
    protected static function validation(): v
    {
        return parent::validationCommon()
            ->key('OrderItemID', v::stringType()->notEmpty()->length(0, 500))
            ->key('ProductID', v::stringType()->notEmpty()->length(0, 500))
            ->key('Qty', v::numeric()->notEmpty())
            ->key('PPU', v::numeric()->notEmpty())
        ;
    }
}
