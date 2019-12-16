<?php

namespace WickedReports\Api;

use WickedReports\Exception\ValidationException;
use WickedReports\WickedReportsException;

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
     * @var bool If false source system should match exactly, otherwise, it would match anything starting
     *              with the specified source system.
     */
    private $wildcardSourceSystem;

    /**
     * @var array Accepted conditions to apply to the latest query.
     */
    private $conditions;

    /**
     * @var false|string Whether to return only the maximum found value of the this field.
     */
    private $getMax = false;

    /**
     * @var bool Return offset number of the record for that data type and source system.
     */
    private $getOffset = false;

    /**
     * LatestEndpoint constructor.
     * @param string $sourceSystem
     * @param string $dataType
     * @throws ValidationException
     */
    public function __construct($sourceSystem, $dataType)
    {
        $this->setSourceSystem($sourceSystem);
        $this->setDataType($dataType);
    }

    /**
     * Generate final request URL
     * @return string
     * @throws WickedReportsException
     */
    public function makeUrl()
    {
        $url = "latest?sourcesystem={$this->sourceSystem}&datatype={$this->dataType}";

        if ($this->getMax && $this->getOffset) {
            throw new WickedReportsException('Cannot have max and offset in the same request.');
        }

        if ($this->getMax) {
            $url .= "&max={$this->getMax}";
        }

        if ($this->getOffset) {
            $url .= "&offset=1";
        }

        if (!$this->getMax && !$this->getOffset) {
            if (!empty($this->sortBy)) {
                $url .= "&sortby={$this->sortBy}";
            }

            if (!empty($this->sortDirection)) {
                $url .= "&order={$this->sortDirection}";
            }
        }

        if ($this->wildcardSourceSystem) {
            $url .= "&like=1";
        }

        if ($this->conditions) {
            foreach ($this->conditions as $field => $expectedValue) {
                $url .= '&' . $field . '=' . urlencode($expectedValue);
            }
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

    /**
     * @return bool
     */
    public function isWildcardSourceSystem(): bool
    {
        return $this->wildcardSourceSystem;
    }

    /**
     * @param bool $wildcardSourceSystem
     */
    public function setWildcardSourceSystem(bool $wildcardSourceSystem)
    {
        $this->wildcardSourceSystem = $wildcardSourceSystem;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @return false|string
     */
    public function isGetMax()
    {
        return $this->getMax;
    }

    /**
     * @param false|string $getMax
     */
    public function setMax($getMax): void
    {
        $this->getMax = $getMax;
    }

    /**
     * @return bool
     */
    public function isGetOffset(): bool
    {
        return $this->getOffset;
    }

    /**
     * @param bool $getOffset
     */
    public function setGetOffset(bool $getOffset)
    {
        $this->getOffset = $getOffset;
    }

}
