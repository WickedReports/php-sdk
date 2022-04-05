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
            ->key('Source', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('Medium', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('Campaign', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('Content', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('Term', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('Clicks', v::numeric()->intVal()->min(0)->length(0, 18))
            ->key('Cost', v::numeric()->floatVal()->min(0)->length(0, 18))
            ->key('AdId', v::stringType()->notEmpty()->length(0, 500))
            ->key('AccountId', v::stringType()->notEmpty()->length(0, 500))
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 500), false)
            ->key('LastUpdatedDate', v::date('Y-m-d H:i:s'), false)
            ->key('ConversionCount', v::numeric()->intVal()->min(0)->length(0, 18), false)
            ->key('ConversionValue', v::numeric()->floatVal()->min(0)->length(0, 18), false)
            ->key('AdStatus', v::stringType()->length(0, 500), false)
            ->key('CampaignStatus', v::stringType()->length(0, 500), false)
            ->key('AdGroupStatus', v::stringType()->length(0, 500), false)
            ->key('AdSetStatus', v::stringType()->length(0, 500), false)
            ->key('AdType', v::stringType()->length(0, 500), false)
            ->key('CampaignId', v::stringType()->length(0, 500), false)
            ->key('AdGroupId', v::stringType()->length(0, 500), false)
        ;
    }
}
