<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class Click extends BaseItem
{
    /**
     * @return v
     */
    protected static function validation()
    {
        return v::arrayType()
            ->key('Email', v::stringType()->notEmpty()->length(0, 255))
            ->key('IP_Address', v::stringType()->notEmpty()->length(0, 50), false)
            ->key('Date_Time', v::date('Y-m-d H:i:s')->notEmpty())
            ->key('Timezone', v::stringType()->notEmpty()->length(0, 10))
            ->key('TimeOffset', v::numeric()->intVal()->min(0)->length(0, 18), false)
            ->key('Source', v::stringType()->length(0, 500), false)
            ->key('Campaign', v::stringType()->length(0, 500), false)
            ->key('Term', v::stringType()->length(0, 500), false)
            ->key('Medium', v::stringType()->length(0, 500), false)
            ->key('Content', v::stringType()->length(0, 500), false)
            ->key('OrderID', v::stringType()->length(0, 500), false)
            ->key('ConversionType', v::stringType()->notEmpty()->length(0, 50))
            ->key('WickedId', v::stringType()->length(0, 100), false)
            ->key('WickedSource', v::stringType()->length(0, 100), false)
        ;
    }
}
