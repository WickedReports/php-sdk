<?php

namespace WickedReports\Item;

use WickedReports\Api\Item\BaseItem;
use PHPUnit\Framework\TestCase;

class BaseItemTest extends TestCase {

    const PROPER_DATA = [
        'SourceSystem'   => 'ActiveCampaign',
        'SourceID'       => 'order-id',
        'CreateDate'     => '2017-08-08 01:02:03',
        'ContactID'      => 'contact-id',
        'ContactEmail'   => 'test@gmail.com',
        'OrderTotal'     => 56.77,
        'Country'        => 'US',
        'City'           => 'New York',
        'State'          => 'New York',
        'SubscriptionID' => 'subscription-id'
    ];

    const PROPER_DATA2 = [
        'SourceSystem'   => 'InfusionSoft',
        'SourceID'       => 'source-id',
        'CreateDate'     => '2017-08-10 01:02:03',
        'ContactID'      => 'new-contact-id',
        'ContactEmail'   => 'tester@gmail.com',
        'OrderTotal'     => 80,
        'Country'        => 'UK',
        'City'           => 'London',
        'State'          => 'London',
        'SubscriptionID' => 'subscr-id'
    ];

    public function testConstruction()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $this->assertNotEmpty($item);
    }

    public function testDirectGet()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->assertSame('ActiveCampaign', $item->SourceSystem);
        $this->assertSame('2017-08-08 01:02:03', $item->CreateDate);
        $this->assertSame(56.77, $item->OrderTotal);
    }

    public function testDirectSet()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $this->assertSame('ActiveCampaign', $item->SourceSystem);

        $item->SourceSystem = 'Google';
        $this->assertSame('Google', $item->SourceSystem);
    }

    public function testDumpingData()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $this->assertSame(self::PROPER_DATA, $item->getData());
    }

    public function testSettingData()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $item->setData(self::PROPER_DATA2);

        $this->assertSame(self::PROPER_DATA2, $item->getData());
    }

    public function testIsFilled()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $this->assertTrue($item->isFilled());

        $item->setData([]);
        $this->assertFalse($item->isFilled());
    }

    public function testJsonSerialize()
    {
        $validJson = '{"SourceSystem":"ActiveCampaign","SourceID":"order-id","CreateDate":"2017-08-08 01:02:03","ContactID":"contact-id","ContactEmail":"test@gmail.com","OrderTotal":56.77,"Country":"US","City":"New York","State":"New York","SubscriptionID":"subscription-id"}';

        $item = $this->getItem([self::PROPER_DATA]);

        $json = $item->toJson();
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($validJson, $json);

        $jsonEncoded = json_encode($item);
        $this->assertJson($jsonEncoded);
        $this->assertJsonStringEqualsJsonString($validJson, $jsonEncoded);
    }

    public function testArrayConvertion()
    {
        $item = $this->getItem([self::PROPER_DATA]);
        $array = $item->toArray();

        $this->assertInternalType('array', $array);
        $this->assertSame(self::PROPER_DATA, $array);
    }

    public function testDatesHandling()
    {
        $this->markTestIncomplete();

        if (0) {
            $reflection = new ReflectionClass($a);
            $reflection_property = $reflection->getProperty('p');
            $reflection_property->setAccessible(true);

            $reflection_property->setValue($a, 2);
        }
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(BaseItem::class, $args);
    }

}