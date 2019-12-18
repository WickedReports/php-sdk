<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderItem extends OrderSub
{
    /**
     * @return v
     */
    protected static function validation()
    {
        return self::validationCommon()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('OrderID', v::stringType()->notEmpty()->length(0, 500))
        ;
    }

    /**
     * @return v
     */
    protected static function validationSub(): v
    {
        return self::validationCommon();
    }

    private static function validationCommon(): v
    {
        return v::arrayType()
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('ProductID', v::stringType()->notEmpty()->length(0, 500))
            ->key('Qty', v::numeric()->notEmpty())
            ->key('PPU', v::numeric()->notEmpty())
        ;
    }
}
