<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Api\Item\Order;
use WickedReports\Exception\ValidationException;

class OrderTest extends TestCase {

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
        'SubscriptionID' => 'subscription-id',
        'IP_Address'     => '193.198.0.1',
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

    public function testCreateDate()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->CreateDate = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->CreateDate = 'wrong';

        $this->resetItem($item);
        $item->CreateDate = new \DateTime('2017-01-01 00:00:00');
        $this->assertSame('2017-01-01 00:00:00', $item->CreateDate);
    }

    public function testOrderTotal()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->OrderTotal = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->OrderTotal = 'strong';

        $this->resetItem($item);
        $item->OrderTotal = 100;
        $this->assertSame(100, $item->OrderTotal);

        $this->resetItem($item);
        $item->OrderTotal = 0;
        $this->assertSame(0, $item->OrderTotal);
    }

    public function testOrderItems()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $orderItem = [
            'SourceSystem' => 'ActiveCampaign',
            'SourceID'     => 'source-id',
            'OrderID'      => 'order-id',
            'ProductID'    => 'product-id',
            'Qty'          => 5,
            'PPU'          => 40
        ];

        $item->setOrderItems([$orderItem]);
        $this->assertSame([$orderItem], $item->getOrderItems());

        $item->setOrderItems(null);
        $this->assertSame(null, $item->getOrderItems());
    }

    public function testOrderPayments()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $orderPayment = [
            'SourceSystem' => 'ActiveCampaign',
            'OrderID'      => 'order-id',
            'PaymentDate'  => '2017-08-17 00:01:00',
            'Amount'       => 500,
            'Status'       => 'APPROVED'
        ];

        $item->setOrderPayments([$orderPayment]);
        $this->assertSame([$orderPayment], $item->getOrderPayments());

        $item->setOrderPayments(null);
        $this->assertSame(null, $item->getOrderPayments());
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(Order::class, $args);
    }

    /**
     * @param BaseItem $item
     */
    private function resetItem($item)
    {
        $item->setData(self::PROPER_DATA);
    }

}