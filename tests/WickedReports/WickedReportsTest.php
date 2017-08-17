<?php

namespace WickedReports\Item;

use PHPUnit\Framework\TestCase;
use WickedReports\WickedReports;

class WickedReportsTest extends TestCase {

    public function testAddContacts()
    {
        $api = new WickedReports('F76AahJFyq7NC25jSjQ4mO2twEXddmhO');

        $result = $api->addContacts([
            [
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
            ]
        ]);

        $this->assertNotEmpty($result->success);
    }

}