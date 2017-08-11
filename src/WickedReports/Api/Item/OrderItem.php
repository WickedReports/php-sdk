<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderItem extends BaseItem {

    /**
     * @return v
     */
    protected function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('OrderID', v::stringType()->notEmpty()->length(0, 500))
            ->key('ProductID', v::stringType()->notEmpty()->length(0, 500))
            ->key('Qty', v::intType()->notEmpty())
            ->key('PPU', v::floatType()->notEmpty())
        ;
    }

}