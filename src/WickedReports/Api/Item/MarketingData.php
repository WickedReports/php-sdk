<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class MarketingData extends BaseItem
{
    /**
     * @return v
     */
    protected static function validation(): v
    {
        return v::arrayType()
            ->key('Date_Time', v::date('Y-m-d H:i:s')->notEmpty())
            ->key('Source', v::stringType()->notEmpty()->length(0, 500))
            ->key('Medium', v::stringType()->notEmpty()->length(0, 500))
            ->key('Campaign', v::stringType()->notEmpty()->length(0, 500))
            ->key('Content', v::stringType()->notEmpty()->length(0, 500))
            ->key('Term', v::stringType()->notEmpty()->length(0, 500))
            ->key('Clicks', v::numeric()->intVal()->min(0)->length(0, 18))
            ->key('Cost', v::numeric()->floatVal()->min(0)->length(0, 18))
            ->key('AdId', v::stringType()->notEmpty()->length(0, 500))
            ->key('AccountId', v::stringType()->notEmpty()->length(0, 500))
            ->key('CampaignId', v::stringType()->notEmpty()->length(0, 500))
            ->key('AdGroupId', v::stringType()->notEmpty()->length(0, 500))
            ->key('ConversionCount', v::numeric()->notEmpty()->length(0, 18))
            ->key('ConversionValue', v::numeric()->notEmpty()->length(0, 18))
        ;
    }
}
