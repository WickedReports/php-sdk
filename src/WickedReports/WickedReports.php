<?php

namespace WickedReports;

use WickedReports\Api\Collection\BaseCollection;
use WickedReports\Api\Collection\Contacts;
use WickedReports\Api\Collection\OrderItems;
use WickedReports\Api\Collection\OrderPayments;
use WickedReports\Api\Collection\Orders;
use WickedReports\Api\Collection\Products;
use WickedReports\Api\LatestEndpoint;

class WickedReports {

    /**
     * @var string URL all API requests are sent to
     */
    private $apiUrl = 'https://api.wickedreports.com/';

    /**
     * @var string API key used to send requests
     */
    private $apiKey;

    /**
     * WickedReports constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param array|Contacts $contacts
     * @return bool|string
     */
    public function addContacts($contacts)
    {
        if (is_array($contacts)) {
            $contacts = new Contacts($contacts);
        }

        return $this->request('contacts', 'POST', $contacts);
    }

    /**
     * @param array|Orders $orders
     * @return bool|string
     */
    public function addOrders($orders)
    {
        if (is_array($orders)) {
            $orders = new Orders($orders);
        }

        return $this->request('orders', 'POST', $orders);
    }

    /**
     * @param array|Products $products
     * @return bool|string
     */
    public function addProducts($products)
    {
        if (is_array($products)) {
            $products = new Products($products);
        }

        return $this->request('products', 'POST', $products);
    }

    /**
     * @param array|OrderPayments $payments
     * @return bool|string
     */
    public function addOrderPayments($payments)
    {
        if (is_array($payments)) {
            $payments = new OrderPayments($payments);
        }

        return $this->request('orderpayments', 'POST', $payments);
    }

    /**
     * @param array|OrderItems $items
     * @return bool|string
     */
    public function addOrderItems($items)
    {
        if (is_array($items)) {
            $items = new OrderItems($items);
        }

        return $this->request('orderitems', 'POST', $items);
    }

    /**
     * Short-hand function for latest endpoint builder
     * @param string $sourceSystem
     * @param string $dataType
     * @param string $sortBy
     * @param string $sortDirection
     * @return bool|string
     */
    public function getLatest($sourceSystem, $dataType, $sortBy = null, $sortDirection = null)
    {
        // Build endpoint URL
        $endpoint = new LatestEndpoint($sourceSystem, $dataType);
        $endpoint->setSortBy($sortBy);
        $endpoint->setSortDirection($sortDirection);

        // Make request and get response
        $response = $this->request($endpoint->makeUrl());

        // Show real item object
        return (new LatestEndpoint\Response($dataType, $response))->getItem();
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array|BaseCollection $rawValues
     * @return bool|string
     */
    private function request($endpoint, $method = 'GET', $rawValues = [])
    {
        $url = "{$this->apiUrl}{$endpoint}";

        if ($rawValues instanceof BaseCollection) {
            // Automatically convert collection into JSON
            $values = $rawValues->toJson();
        }
        else if ($method === 'GET') {
            $values = http_build_query($rawValues);
        }
        else {
            $values = json_encode($rawValues);
        }

        $options = [
            'http' => [
                'method'  => $method,
                'content' => $values,
                'header'  => "apikey: {$this->apiKey}\r\n"
                     ."Content-Type: application/json\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result !== false) {
            return $result;
        }

        return false;
    }

}
