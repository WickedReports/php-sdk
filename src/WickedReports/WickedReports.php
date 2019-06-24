<?php

namespace WickedReports;

use WickedReports\Api\Collection\BaseCollection;
use WickedReports\Api\Collection\Contacts;
use WickedReports\Api\Collection\OrderItems;
use WickedReports\Api\Collection\OrderPayments;
use WickedReports\Api\Collection\Orders;
use WickedReports\Api\Collection\Products;
use WickedReports\Api\LatestEndpoint;
use WickedReports\Exception\ValidationException;

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
     * @var bool
     */
    private $testMode = FALSE;

    /**
     * WickedReports constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey, $testMode = NULL)
    {
        $this->apiKey = $apiKey;

        if (isset($testMode)) {
            $this->setTestMode($testMode);
        }
    }

    /**
     * @param array|Contacts $contacts
     * @return bool|string
     * @throws ValidationException
     */
    public function addContacts($contacts)
    {
        if (is_array($contacts)) {
            $contacts = new Contacts($contacts);
        }

        if ( ! $contacts instanceof Contacts) {
            throw new ValidationException('$contacts must be either array or Contacts type');
        }

        return $this->request('contacts', 'POST', $contacts);
    }

    /**
     * @param array|Orders $orders
     * @return bool|string
     * @throws ValidationException
     */
    public function addOrders($orders)
    {
        if (is_array($orders)) {
            $orders = new Orders($orders);
        }

        if ( ! $orders instanceof Orders) {
            throw new ValidationException('$orders must be either array or Orders type');
        }

        return $this->request('orders', 'POST', $orders);
    }

    /**
     * @param array|Products $products
     * @return bool|string
     * @throws ValidationException
     */
    public function addProducts($products)
    {
        if (is_array($products)) {
            $products = new Products($products);
        }

        if ( ! $products instanceof Products) {
            throw new ValidationException('$products must be either array or Products type');
        }

        return $this->request('products', 'POST', $products);
    }

    /**
     * @param array|OrderPayments $payments
     * @return bool|string
     * @throws ValidationException
     */
    public function addOrderPayments($payments)
    {
        if (is_array($payments)) {
            $payments = new OrderPayments($payments);
        }

        if ( ! $payments instanceof OrderPayments) {
            throw new ValidationException('$payments must be either array or OrderPayments type');
        }

        return $this->request('orderpayments', 'POST', $payments);
    }

    /**
     * @param array|OrderItems $items
     * @return bool|string
     * @throws ValidationException
     */
    public function addOrderItems($items)
    {
        if (is_array($items)) {
            $items = new OrderItems($items);
        }

        if ( ! $items instanceof OrderItems) {
            throw new ValidationException('$items must be either array or OrderItems type');
        }

        return $this->request('orderitems', 'POST', $items);
    }

    /**
     * Short-hand function for latest endpoint builder
     * @param string $sourceSystem
     * @param string $dataType
     * @param string $timezone Timezone to convert back from UTC
     * @param string $sortBy
     * @param string $sortDirection
     * @param bool $wildcardSourceSystem
     * @param array $cond
     * @return bool|string
     * @throws ValidationException
     * @throws WickedReportsException
     */
    public function getLatest($sourceSystem, $dataType, $timezone, $sortBy = null, $sortDirection = null,
                              $wildcardSourceSystem=false, $cond=[])
    {
        // Build endpoint URL
        $endpoint = new LatestEndpoint($sourceSystem, $dataType);
        $endpoint->setSortBy($sortBy);
        $endpoint->setSortDirection($sortDirection);
        $endpoint->setWildcardSourceSystem($wildcardSourceSystem);
        $endpoint->setConditions($cond);

        // Make request and get response
        $response = $this->request($endpoint->makeUrl(), 'GET', [], 5);

        // Show real item object
        return (new LatestEndpoint\Response($dataType, $response))
            ->setTimezone($timezone)
            ->getItem();
    }

    /**
     * @param $sourceSystem
     * @param $dataType
     * @param $field
     * @param bool $wildcardSourceSystem
     * @param array $cond
     * @return LatestEndpoint\Response
     * @throws ValidationException
     * @throws WickedReportsException
     */
    public function getMax($sourceSystem, $dataType, $field,
                           $wildcardSourceSystem=false, $cond=[]) {
        $endpoint = new LatestEndpoint($sourceSystem, $dataType);
        $endpoint->setWildcardSourceSystem($wildcardSourceSystem);
        $endpoint->setConditions($cond);
        $endpoint->setMax($field);

        $response = $this->request($endpoint->makeUrl(), 'GET', [], 5);

        return (new LatestEndpoint\Response($dataType, $response));
    }

    /**
     * @param $sourceSystem
     * @param $dataType
     * @param array $cond
     * @return LatestEndpoint\Response
     * @throws ValidationException
     * @throws WickedReportsException
     */
    public function getOffset($sourceSystem, $dataType, $cond=[])
    {
        $endpoint = new LatestEndpoint($sourceSystem, $dataType);
        $endpoint->setConditions($cond);
        $endpoint->setGetOffset(true);

        $response = $this->request($endpoint->makeUrl(), 'GET', [], 5);

        return new LatestEndpoint\Response($dataType, $response);
    }

    /**
     * @return bool
     */
    public function getTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param bool $mode
     */
    public function setTestMode($mode)
    {
        $this->testMode = $mode;
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array|BaseCollection $rawValues
     * @param bool $retry The number of times to retry on a request if it fails, or false for no retry
     * @return bool|string
     * @throws ValidationException
     * @throws WickedReportsException
     */
    private function request($endpoint, $method = 'GET', $rawValues = [], $retry=false)
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

        $header = "apikey: {$this->apiKey}\r\n"
            ."Content-Type: application/json\r\n";

        if ($this->testMode) {
            $header .= "test: 1\r\n";
        }

        if (mb_strlen($values) > 10000000) {
            throw new ValidationException('Provided data is bigger than 10 Mbytes limit');
        }

        $options = [
            'http' => [
                'method'  => $method,
                'content' => $values,
                'header'  => $header
            ]
        ];

        $context = stream_context_create($options);

        $attempt = 1;
        $result = false;
        do {
            try {
                $result = @file_get_contents($url, false, $context);
            } catch (\Throwable $e) {
                if (!$retry || $attempt >= $retry) {
                    throw new WickedReportsException($e->getMessage(), $e->getCode(), $e);
                }
            }
            $attempt++;
            sleep(3);
        } while ($result === false && $retry && $attempt < $retry);

        if ($result !== false) {
            $result = json_decode($result);
            return $result;
        }

        return false;
    }

}
