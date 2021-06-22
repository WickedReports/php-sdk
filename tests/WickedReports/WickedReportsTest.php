<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\Api\Item\Contact;
use WickedReports\Api\LatestEndpoint\Response;
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

    public function testAddContactsTestMode()
    {
        $api = new WickedReports(self::APIKEY, true);
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

    public function testAddOrdersTestMode()
    {
        $api = new WickedReports(self::APIKEY, true);
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

    public function testAddProductsTestMode()
    {
        $api = new WickedReports(self::APIKEY, true);
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

    public function testAddOrderPaymentsTestMode()
    {
        $api = new WickedReports(self::APIKEY, true);
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

    public function testAddOrderItemsTestMode()
    {
        $api = new WickedReports(self::APIKEY, true);
        $result = $api->addOrderItems([OrderItemTest::PROPER_DATA]);

        $this->assertNotEmpty($result->success);
        $this->assertContains('Successfully', $result->success);
    }

    public function testGetLatest()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->getLatest('ActiveCampaign', 'contacts', 'UTC');

        $this->assertNotEmpty($result);

        // We have requested this item type
        $this->assertInstanceOf(Contact::class, $result);

        $data = $result->getData();
        $this->assertInternalType('array', $data);

        // We have requested this SourceSystem
        $this->assertSame('ActiveCampaign', $data['SourceSystem']);
    }

    public function testGetMax()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->getMax('ActiveCampaign', 'contacts', 'SourceID');

        $this->assertNotEmpty($result);

        $this->assertInstanceOf(Response::class, $result);
        $data = $result->getData();

        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data['SourceID']);

        $this->assertInternalType('string', $data['SourceID']);
    }

    public function testGetOffset()
    {
        $api = new WickedReports(self::APIKEY);
        $result = $api->getOffset('Shopify', 'contacts');

        $this->assertNotEmpty($result);
        $data = $result->getData();

        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertInternalType('integer', $data['offset']);
        $this->assertEquals('Shopify', $data['sourceSystem']);
        $this->assertEquals('contacts', $data['dataType']);
    }
}