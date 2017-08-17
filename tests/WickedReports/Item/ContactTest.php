<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Api\Item\Contact;
use WickedReports\Exception\ValidationException;

class ContactTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem' => 'ActiveCampaign',
        'SourceID'     => 'order-id',
        'CreateDate'   => '2017-08-08 01:02:03',
        'timezone'     => 'Europe/London',
        'Email'        => 'test@gmail.com',
        'FirstName'    => 'John',
        'LastName'     => 'Wick',
        'City'         => 'London',
        'State'        => 'London',
        'Country'      => 'UK',
        'IP_Address'   => '127.0.0.1',
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

    public function testEmail()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Email = '';
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(Contact::class, $args);
    }

    /**
     * @param BaseItem $item
     */
    private function resetItem($item)
    {
        $item->setData(self::PROPER_DATA);
    }

}