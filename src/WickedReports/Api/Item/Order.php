<?php

namespace WickedReports\Api\Item;

use Respect\Validation\Validator as v;
use WickedReports\Api\Collection\OrderItems;
use WickedReports\Api\Collection\OrderPayments;

class Order extends BaseItem {

    /**
     * @var array
     */
    protected $dates = ['CreateDate'];

    /**
     * @return mixed
     */
    public function getOrderItems()
    {
        return isset($this->data['OrderItems']) ? $this->data['OrderItems'] : null;
    }

    /**
     * @param array|OrderItems $items
     */
    public function setOrderItems($items)
    {
        if ($items instanceof OrderItems) {
            $items = $items->toPlainArray();
        }

        $this->data['OrderItems'] = $items;
    }

    /**
     * @return mixed
     */
    public function getOrderPayments()
    {
        return isset($this->data['OrderPayments']) ? $this->data['OrderPayments'] : null;
    }

    /**
     * @param array|OrderPayments $items
     */
    public function setOrderPayments($items)
    {
        if ($items instanceof OrderPayments) {
            $items = $items->toPlainArray();
        }

        $this->data['OrderPayments'] = $items;
    }

    /**
     * @return v
     */
    protected static function validation()
    {
        return v::arrayType()
            ->key('SourceSystem', v::stringType()->notEmpty()->length(0, 255))
            ->key('SourceID', v::stringType()->notEmpty()->length(0, 500))
            ->key('CreateDate', v::date('Y-m-d H:i:s')->notEmpty())
            ->key('ContactID', v::optional(v::stringType()->length(0, 500)))
            ->key('ContactEmail', v::optional(v::stringType()->length(0, 500)))
            ->key('OrderTotal', v::numeric()->length(0, 18))

            // Addional nested structures
            ->key('OrderItems', v::optional(v::arrayType()->each(OrderItem::getValidation())), false)
            ->key('OrderPayments', v::optional(v::arrayType()->each(OrderPayment::getValidation())), false)
        ;
    }

}