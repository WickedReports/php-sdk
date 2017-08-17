<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\OrderItems;
use WickedReports\Api\Item\OrderItem;

class OrderItemsTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'SourceID'     => 'source-id',
        'OrderID'      => 'order-id',
        'ProductID'    => 'product-id',
        'Qty'          => 5,
        'PPU'          => 40
    ];

    public function testType()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertInstanceOf(OrderItem::class, $collection[0]);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCollection($args)
    {
        return $this->getMockForAbstractClass(OrderItems::class, $args);
    }

}