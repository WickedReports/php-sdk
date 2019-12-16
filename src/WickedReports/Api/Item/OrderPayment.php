<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;

class OrderPayment extends BaseItem
{
    const STATUS_DEFAULT = '';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_FAILED = 'FAILED';
    const STATUS_REFUNDED = 'REFUNDED';
    const STATUS_PARTIALLY_REFUNDED = 'PARTIALLY REFUNDED';
    const STATUS_VOIDED = 'VOIDED';
    const STATUS_DECLINED = 'DECLINED';
    const STATUS_CHARGEBACK = 'CHARGEBACK';
    const STATUS_CHARGEBACKS = 'CHARGEBACKS';
    const STATUS_ERROR = 'ERROR';
    const STATUS_WRITTEN = 'WRITTEN';

    /**
     * @var array
     */
    protected $dates = ['PaymentDate'];

    /**
     * @return v
     */
    protected static function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('OrderID', v::stringType()->notEmpty()->length(0, 500))
            ->key('PaymentDate', v::date('Y-m-d H:i:s'))
            ->key('Amount', v::numeric()->min(0))
            ->key('Status', v::stringType()->length(0, 500)->in(
                [
                    self::STATUS_DEFAULT,
                    self::STATUS_APPROVED,
                    self::STATUS_FAILED,
                    self::STATUS_REFUNDED,
                    self::STATUS_PARTIALLY_REFUNDED,
                    self::STATUS_VOIDED,
                    self::STATUS_DECLINED,
                    self::STATUS_CHARGEBACK,
                    self::STATUS_CHARGEBACKS,
                    self::STATUS_ERROR,
                    self::STATUS_WRITTEN,
                ])
            )
        ;
    }
}
