<?php

namespace WickedReports\Api;

use WickedReports\Exception\ValidationException;

class LatestEndpoint {

    const ALLOWED_DATATYPES = ['contacts', 'orders', 'orderitems', 'payments', 'products'];

    /**
     * @var string
     */
    private $sourceSystem;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var string Field to sort by
     */
    private $sortBy;

    /**
     * @var string Sorting direction
     */
    private $sortDirection;

    /**
     * LatestEndpoint constructor.
     * @param string $sourceSystem
     * @param string $dataType
     */
    public function __construct($sourceSystem, $dataType)
    {
        $this->setSourceSystem($sourceSystem);
        $this->setDataType($dataType);
    }

    /**
     * Generate final request URL
     * @return string
     */
    public function makeUrl()
    {
        $url = "latest?sourcesystem={$this->sourceSystem}&datatype={$this->dataType}";

        if ( ! empty($this->sortBy)) {
            $url .= "&sortby={$this->sortBy}";
        }

        if ( ! empty($this->sortDirection)) {
            $url .= "&order={$this->sortDirection}";
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getSourceSystem()
    {
        return $this->sourceSystem;
    }

    /**
     * @param string $sourceSystem
     * @throws ValidationException
     */
    public function setSourceSystem($sourceSystem)
    {
        if (empty($sourceSystem)) {
            throw new ValidationException('Source system cannot be empty');
        }

        $this->sourceSystem = $sourceSystem;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     * @throws ValidationException
     */
    public function setDataType($dataType)
    {
        if (empty($dataType)) {
            throw new ValidationException('Data type cannot be empty');
        }

        if ( ! in_array($dataType, static::ALLOWED_DATATYPES, true)) {
            throw new ValidationException('Data type should be one of these: '.implode(', ', static::ALLOWED_DATATYPES));
        }

        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return string
     */
    public function getSortDirection()
    {
        return $this->sortDirection;
    }

    /**
     * @param string $sortDirection
     */
    public function setSortDirection($sortDirection)
    {
        $this->sortDirection = $sortDirection;
    }

}