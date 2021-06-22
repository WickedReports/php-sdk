<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Api\Item\OrderPayment;
use WickedReports\Exception\ValidationException;

class OrderPaymentTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'OrderID'      => 'order-id',
        'PaymentDate'  => '2017-01-01 00:01:00',
        'timezone'     => 'Europe/London',
        'Amount'       => 100,
        'Status'       => 'APPROVED'
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

    public function testOrderID()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->OrderID = '';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->OrderID = '11111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 111111111111111111111111111111111111111111111111111111111111111111 11111111111111111111111111111111111111111111111111111111111111111 1111111111111111111111111111111';
    }

    public function testPaymentDate()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->PaymentDate = 'wrong';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->PaymentDate = 2017;

        $this->resetItem($item);
        $item->PaymentDate = '2017-08-01 00:01:00';
        $this->assertSame('2017-08-01 00:01:00', $item->PaymentDate);
    }

    public function testAmount()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Amount = 'wrong';

        $this->resetItem($item);
        $this->expectException(ValidationException::class);
        $item->Amount = 100;

        $this->resetItem($item);
        $item->Amount = '100';
        $this->assertSame('100', $item->Amount);

        $this->resetItem($item);
        $item->Amount = 100.1;
        $this->assertSame(100.1, $item->Amount);
    }

    public function testStatus()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $item->Status = 'APPROVED';
        $this->assertSame('APPROVED', $item->Status);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(OrderPayment::class, $args);
    }

    /**
     * @param BaseItem $item
     */
    private function resetItem($item)
    {
        $item->setData(self::PROPER_DATA);
    }

}