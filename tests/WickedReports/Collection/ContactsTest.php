<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\Contacts;
use WickedReports\Api\Item\Contact;

class ContactsTest extends TestCase {

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

    public function testType()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertInstanceOf(Contact::class, $collection[0]);
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCollection($args)
    {
        return $this->getMockForAbstractClass(Contacts::class, $args);
    }

}