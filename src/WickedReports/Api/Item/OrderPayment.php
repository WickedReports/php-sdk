<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderPayment extends OrderSub
{
    const STATUS_DEFAULT = '';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_VOIDED = 'VOIDED';
    const STATUS_REFUNDED = 'REFUNDED';
    const STATUS_PARTIALLY_REFUNDED = 'PARTIALLY REFUNDED';
    const STATUS_FAILED = 'FAILED';
    const STATUS_DECLINED = 'DECLINED';

    /**
     * @var array
     */
    protected $dates = ['PaymentDate'];

    /**
     * @return v
     */
    protected static function validation()
    {
        return self::validationCommon()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('OrderID', v::stringType()->notEmpty()->length(0, 500))
        ;
    }

    /**
     * @return v
     */
    protected static function validationSub()
    {
        return self::validationCommon();
    }

    /**
     * @return v
     */
    private static function validationCommon()
    {
        return v::arrayType()
            ->key('PaymentDate', v::date('Y-m-d H:i:s'))
            ->key('Amount', v::numeric()->min(0))
            ->key('Status', v::stringType()->length(0, 500))
        ;
    }
}
