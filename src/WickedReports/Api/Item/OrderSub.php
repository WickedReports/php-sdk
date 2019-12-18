<?php

namespace WickedReports\Api\Item;

class OrderSub extends BaseItem
{
    /**
     * @return mixed
     */
    public static function getValidationSub()
    {
        return static::validationSub();
    }
}
