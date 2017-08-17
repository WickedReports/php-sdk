<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\Products;
use WickedReports\Api\Item\Product;

class ProductsTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'SourceID'     => 'source-id',
        'ProductName'  => 'New Product',
        'ProductPrice' => 1000
    ];

    public function testType()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertInstanceOf(Product::class, $collection[0]);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCollection($args)
    {
        return $this->getMockForAbstractClass(Products::class, $args);
    }

}