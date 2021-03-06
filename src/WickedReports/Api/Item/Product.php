<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class Product extends BaseItem
{
    /**
     * @return v
     */
    protected static function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('ProductName', v::stringType()->regex("/[\d\S]+/i")->length(0, 500))
            ->key('ProductPrice', v::numeric()->length(0, 18))
        ;
    }
}
