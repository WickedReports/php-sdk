<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderSub extends BaseItem
{
    /**
     * @return mixed
     */
    public static function getValidationSub()
    {
        return static::validationSub();
    }

    /**
     * @return v
     */
    protected static function validationSub(): v
    {
        return self::validationCommon();
    }

    /**
     * @return v
     */
    protected static function validationCommon(): v
    {
        return v::arrayType();
    }
}
