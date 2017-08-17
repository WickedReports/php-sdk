<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\Orders;
use WickedReports\Api\Item\Order;

class OrdersTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem'   => 'ActiveCampaign',
        'SourceID'       => 'order-id',
        'CreateDate'     => '2017-08-08 01:02:03',
        'timezone'       => 'Europe/London',
        'ContactID'      => 'contact-id',
        'ContactEmail'   => 'test@gmail.com',
        'OrderTotal'     => 56.77,
        'Country'        => 'US',
        'City'           => 'New York',
        'State'          => 'New York',
        'SubscriptionID' => 'subscription-id'
    ];

    public function testType()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertInstanceOf(Order::class, $collection[0]);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCollection($args)
    {
        return $this->getMockForAbstractClass(Orders::class, $args);
    }

}