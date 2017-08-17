<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\Contact;
use WickedReports\WickedReports;

class WickedReportsTest extends TestCase {

    const APIKEY = 'F76AahJFyq7NC25jSjQ4mO2twEXddmhO';

    public function testAddContacts()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->addContacts([ContactTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testAddOrders()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->addOrders([OrderTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testAddProducts()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->addProducts([ProductTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testAddOrderPayments()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->addOrderPayments([OrderPaymentTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testAddOrderItems()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->addOrderItems([OrderItemTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testGetLatest()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->getLatest('ActiveCampaign', 'contacts');

        $this->assertNotEmpty($result);

        // We have requested this item type
        $this->assertInstanceOf(Contact::class, $result);

        $data = $result->getData();
        $this->assertInternalType('array', $data);

        // We have requested this SourceSystem
        $this->assertSame('ActiveCampaign', $data['SourceSystem']);
    }

}