<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Api\Item\OrderItem;
use WickedReports\Exception\ValidationException;

class OrderItemTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'SourceID'     => 'source-id',
        'OrderID'      => 'order-id',
        'ProductID'    => 'product-id',
        'Qty'          => 5,
        'PPU'          => 40
    ];

    public function testSourceSystem()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->SourceSystem = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->SourceSystem = '11111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 111111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 1111111111111111111111111111111';
    }

    public function testSourceID()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->SourceID = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->SourceID = '11111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 111111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 1111111111111111111111111111111';
    }

    public function testOrderID()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->OrderID = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->OrderID = '11111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 111111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 1111111111111111111111111111111';
    }

    public function testProductID()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->ProductID = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->ProductID = '11111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 111111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 1111111111111111111111111111111';
    }

    public function testQty()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Qty = '';

        $this->resetItem($item);
        $item->Qty = 10;
        $this->assertSame(10, $item->Qty);

        $this->resetItem($item);
        $item->Qty = '10';
        $this->assertSame('10', $item->Qty);
    }

    public function testPPU()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->PPU = '';

        $this->resetItem($item);
        $item->PPU = 10;
        $this->assertSame(10, $item->PPU);

        $this->resetItem($item);
        $item->PPU = '10';
        $this->assertSame('10', $item->PPU);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(OrderItem::class, $args);
    }

    /**
     * @param BaseItem $item
     */
    private function resetItem($item)
    {
        $item->setData(self::PROPER_DATA);
    }

}