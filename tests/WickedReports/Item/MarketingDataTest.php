<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\MarketingData;
use WickedReports\Exception\ValidationException;

class MarketingDataTest extends TestCase
{
    const PROPER_DATA = [
        'Date_Time' => '2017-08-08 01:02:03',
        'Source' => 'TestSource',
        'Medium' => 'TestMedium',
        'Campaign' => 'TestCampaign',
        'Content' => 'TestContent',
        'Term' => 'TestTerm',
        'Clicks' => 77,
        'Cost' => 33.11,
        'AdId' => 'TestAdId',
        'AccountId' => 'TestAccountId',
    ];

    public function testSuccess()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->assertSame('TestSource', $item->Source);
    }

    public function testDate()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Date_Time = '';
    }

    public function testSource()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Source = null;
    }

    public function testMedium()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Medium = null;
    }

    public function testCampaign()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Campaign = null;
    }

    public function testContent()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Content = null;
    }

    public function testTerm()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Term = null;
    }

    public function testClicks()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Clicks = 'test_fail';
    }

    public function testCost()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->Cost = 'test_fail';
    }

    public function testAdId()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->AdId = 0;
    }

    public function testAccountId()
    {
        $item = $this->getItem([self::PROPER_DATA]);

        $this->expectException(ValidationException::class);
        $item->AccountId = 0;
    }

    /**
     * @param array $args
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getItem($args)
    {
        return $this->getMockForAbstractClass(MarketingData::class, $args);
    }
}