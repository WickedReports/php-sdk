<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class Order extends BaseItem {

    /**
     * @return v
     */
    protected function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('CreateDate', v::date('Y-m-d H:i:s')->notEmpty())
            ->key('ContactID', v::stringType()->length(0, 500))
            ->key('ContactEmail', v::stringType()->length(0, 500))
            ->key('OrderTotal', v::floatType()->notEmpty()->length(0, 18))
            ->key('Country', v::stringType()->length(0, 255))
            ->key('City', v::stringType()->length(0, 255))
            ->key('State', v::stringType()->length(0, 255))
            ->key('SubscriptionID', v::stringType()->length(0, 500))
        ;
    }

}