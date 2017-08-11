<?php

use WickedReports\Api\Item\Order;
use WickedReports\Api\Collection\Orders;

/**
 * Creating item object
 */

// When you create an object with wrong data, you get an error
$order = new Order([
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
]);

// You can get values directly
echo $order->SourceID;

// You can set values directly
$order->SourceID = 'new-source-id';

// If you put wrong data inside, you get an error
$order->CreateDate = 'NOT-A-DATE';

/**
 * Creating collections
 */

// You can create collection based on plain arrays
// Plain arrays are automatically converted to real item objects
$orders = new Orders([
    [
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
    ]
]);

// Or on item objects
$orders = new Orders([
    new Order([
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
    ])
]);

// You can use collection as an usual array
echo count($orders);
echo $orders[0];
$order[0] = [];

// For orders, you can handle OrderItems/OrderPayments right with your collection
$order->setOrderItems([]);
$order->getOrderItems();

// When you have a data, you can use our API to work with it
$api = new \WickedReports\WickedReports($yourApiKey);

// You can pass a prepared collection, or simple array of arrays
$api->addOrders($orders);

/**
 * Latest endpoint
 */

// Use latest endpoint like this
// You will get a new Contact() object to work with
$contact = $api->getLatest('ActiveCampaign', 'contacts');

// To get plain array use
$contact->toArray();