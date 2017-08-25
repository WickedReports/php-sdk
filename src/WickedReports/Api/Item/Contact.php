<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class Contact extends BaseItem {

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
            ->key('FirstName', v::optional(v::stringType()->length(0, 500)))
            ->key('LastName', v::optional(v::stringType()->length(0, 500)))
            ->key('City', v::optional(v::stringType()->length(0, 500)))
            ->key('State', v::optional(v::stringType()->length(0, 500)))
            ->key('Country', v::optional(v::stringType()->length(0, 500)))
            ->key('IP_Address', v::optional(v::stringType()->length(0, 500)))
        ;
    }

}