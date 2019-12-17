<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class Contact extends BaseItem
{

    /**
     * @var array
     */
    protected $dates = ['CreateDate'];

    /**
     * @return v
     */
    protected static function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('CreateDate', v::date('Y-m-d H:i:s')->notEmpty())
            ->key('Email', v::stringType()->notEmpty()->length(0, 500))
        ;
    }
}
