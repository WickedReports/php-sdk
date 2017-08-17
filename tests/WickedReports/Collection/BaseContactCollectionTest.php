<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Collection\Contacts;
use WickedReports\Api\Item\Contact;
use WickedReports\Exception\ValidationException;

class BaseContactCollectionTest extends TestCase {

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

    const PROPER_DATA2 = [
        'SourceSystem' => 'Infusionsoft',
        'SourceID'     => 'order-id',
        'CreateDate'   => '2017-08-08 01:02:03',
        'timezone'     => 'Europe/London',
        'Email'        => 'tester@gmail.com',
        'FirstName'    => 'John',
        'LastName'     => 'Wicked',
        'City'         => 'London',
        'State'        => 'London',
        'Country'      => 'UK',
        'IP_Address'   => '127.0.0.2',
    ];

    public function testConstruction()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $this->assertNotEmpty($collection);
    }

    public function testSize()
    {
        $items = array_fill(0, 1100, self::PROPER_DATA);

        $this->expectException(ValidationException::class);
        $collection = $this->getCollection([$items]);
    }

    public function testJsonSerialize()
    {
        $validJson = '[{"SourceSystem":"ActiveCampaign","SourceID":"order-id","CreateDate":"2017-08-08 00:02:03","timezone":"Europe\/London","Email":"test@gmail.com","FirstName":"John","LastName":"Wick","City":"London","State":"London","Country":"UK","IP_Address":"127.0.0.1"}]';

        $collection = $this->getCollection([[self::PROPER_DATA]]);

        $json = $collection->toJson();
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($validJson, $json);

        $jsonEncoded = json_encode($collection);
        $this->assertJson($jsonEncoded);
        $this->assertJsonStringEqualsJsonString($validJson, $jsonEncoded);
    }

    public function testArrayConvertion()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);
        $array = $collection->getItems();

        $this->assertInternalType('array', $array);
        $this->assertEquals([new Contact(self::PROPER_DATA)], $array);
    }

    public function testArrayFunctions()
    {
        $collection = $this->getCollection([[self::PROPER_DATA]]);

        $this->assertSame(1, $collection->count());
        $this->assertEquals(new Contact(self::PROPER_DATA), $collection[0]);

        $this->assertTrue($collection->has(0));
        $this->assertFalse($collection->has(1));

        $this->assertFalse($collection->isEmpty());

        $this->assertSame([0], $collection->keys());

        $collection[0] = self::PROPER_DATA2;
        $this->assertEquals(new Contact(self::PROPER_DATA2), $collection[0]);
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