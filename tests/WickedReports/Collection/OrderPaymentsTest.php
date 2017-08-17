<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\OrderPayments;
use WickedReports\Api\Item\OrderPayment;

class OrderPaymentsTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'OrderID'      => 'order-id',
        'PaymentDate'  => '2017-01-01 00:01:00',
        'timezone'     => 'Europe/London',
        'Amount'       => 100,
        'Status'       => 'APPROVED'
    ];

    public function testType()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertInstanceOf(OrderPayment::class, $collection[0]);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCollection($args)
    {
        return $this->getMockForAbstractClass(OrderPayments::class, $args);
    }

}