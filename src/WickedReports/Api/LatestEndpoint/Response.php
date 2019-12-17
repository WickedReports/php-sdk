<?php

namespace WickedReports\Api\LatestEndpoint;

use WickedReports\Api\Item\BaseItem;
use WickedReports\Exception\ValidationException;

class Response
{
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
     * @var string Timezone to convert back from UTC
     */
    private $timezone;

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
     * @throws ValidationException
     */
    public function getItem()
    {
        if (empty($this->timezone)) {
            throw new ValidationException('You have to provide valid `timezone` value');
        }

        $itemClass = static::TYPES[$this->type] ?? null;

        if ($itemClass === null) {
            throw new ValidationException('No corresponding item type class found');
        }

        if (empty($this->data)) {
            // No item data returned
            return null;
        }

        // We save API data as UTC, so we should build object with UTC
        $this->data['timezone'] = 'UTC';

        /** @var BaseItem $item */
        $item = new $itemClass($this->data);

        // Convert item date back to needle timezone
        $item->convertToTimezone($this->timezone);

        return $item;
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
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * @return $this
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
        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }
}
