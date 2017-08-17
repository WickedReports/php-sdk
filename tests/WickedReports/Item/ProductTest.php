<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Api\Item\Product;
use WickedReports\Exception\ValidationException;

class ProductTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'SourceID'     => 'source-id',
        'ProductName'  => 'New Product',
        'ProductPrice' => 1000
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

    public function testProductName()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->ProductName = '';

        $this->resetItem($item);
        $item->ProductName = 'Newer Product';
        $this->assertSame('Newer Product', $item->ProductName);
    }

    public function testProductPrice()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->ProductPrice = '';

        $this->resetItem($item);
        $item->ProductPrice = 100;
        $this->assertSame(100, $item->ProductPrice);

        $this->resetItem($item);
        $item->ProductPrice = '100';
        $this->assertSame('100', $item->ProductPrice);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(Product::class, $args);
    }

    /**
     * @param BaseItem $item
     */
    private function resetItem($item)
    {
        $item->setData(self::PROPER_DATA);
    }

}