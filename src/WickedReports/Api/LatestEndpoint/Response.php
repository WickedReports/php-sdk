<?php

namespace WickedReports\Api\LatestEndpoint;

use WickedReports\Api\Item\BaseItem;

class Response {

    const TYPES = [
        'contacts'   => \WickedReports\Api\Item\Contact::class,
        'orders'     => \WickedReports\Api\Item\Order::class,
        'orderitems' => \WickedReports\Api\Item\OrderItem::class,
        'payments'   => \WickedReports\Api\Item\OrderPayment::class,
        'products'   => \WickedReports\Api\Item\Product::class,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var array Response item data
     */
    private $data = [];

    /**
     * Response constructor.
     * @param string $type
     * @param string $response
     */
    public function __construct($type, $response)
    {
        $this->type = $type;
        $this->setData($response);
    }

    /**
     * Get object item
     * @return BaseItem|null
     */
    public function getItem()
    {
        $item_class = isset(static::TYPES[$this->type]) ? static::TYPES[$this->type] : null;

        if ( ! isset($item_class)) {
            return null;
        }

        // Add our timezone
        $this->data['timezone'] = 'EST';

        return new $item_class($this->data);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|string $data
     */
    public function setData($data)
    {
        if (is_string($data)) {
            // Convert string to array
            $data = json_decode($data, TRUE);
        }

        if (is_object($data)) {
            // Convert object to array
            $data = get_object_vars($data);
        }

        $this->data = $data;
    }

}