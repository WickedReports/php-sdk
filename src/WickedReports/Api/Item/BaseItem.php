<?php

namespace WickedReports\Api\Item;

use JsonSerializable;
use WickedReports\Exception\ValidationException;

abstract class BaseItem implements JsonSerializable {

    /**
     * Item data array
     * @var array
     */
    protected $data = [];

    /**
     * Date fields
     * @var array
     */
    protected $dates = [];

    /**
     * Is date converted to timezone already
     * @var array
     */
    protected $convertedDates = [];

    /**
     * BaseItem constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }

    /**
     * Get field directly
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;

        $this->dateConversions([$name => $value], 'before');
        $this->handleDates();
        $this->validate();
        $this->dateConversions([$name => $value], 'after');
    }

    /**
     * Get item data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set new item data
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;

        $this->dateConversions($data, 'before');
        $this->handleDates();
        $this->validate();
        $this->dateConversions($data, 'after');
    }

    /**
     * Check whether item has some data in it
     * @return bool
     */
    public function isFilled()
    {
        return ! empty($this->data);
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        $validation = static::validation();

        if ( ! $validation) {
            return true;
        }

        if ( ! $validation instanceof \Respect\Validation\Validator) {
            throw new ValidationException('Validation should be instance of \Respect\Validation\Validator');
        }

        try {
            $validation->assert($this->getData());
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            throw new ValidationException($e->getFullMessage());
        }
        catch (\Respect\Validation\Exceptions\ValidationException $e) {
            throw new ValidationException($e->getMainMessage());
        }
        catch (\Exception $e) {
            throw new ValidationException($e->getMessage());
        }

        return true;
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }

    /**
     * @return mixed
     */
    public static function getValidation()
    {
        return static::validation();
    }

    /**
     * @param array $newData
     * @param string $stage
     */
    public function dateConversions(array $newData, $stage)
    {
        if (empty($this->dates)) {
            return;
        }

        foreach ($this->dates as $field) {
            $result = null;
            $value = isset($newData[$field]) ? $newData[$field] : null;

            // Date will be converted if value not empty
            $isFilled = ! empty($value);

            if ($stage === 'before' && $isFilled) {
                // Clear state, it will be handled anew
                $result = false;
            }
            else if ($stage === 'after' && $isFilled) {
                // Handled already
                $result = true;
            }

            if (isset($result)) {
                $this->convertedDates[$field] = $result;
            }
        }
    }

    /**
     * Helper function for latest endpoint to convert from UTC back to client's timezone
     * @param string $timezone
     */
    public function convertToTimezone($timezone)
    {
        if ( ! $this->dates || ! $this->convertedDates) {
            // Object should be with dates and with already converted values
            return;
        }

        foreach ($this->dates as $field) {
            $value = $this->data[$field];

            if (empty($value)) {
                // No value provided
                continue;
            }

            // Convert to needle timezone
            $value = new \DateTime($value, new \DateTimeZone('UTC'));
            $value->setTimezone(new \DateTimeZone($timezone));

            // Use correct format, save value back
            $this->data[$field] = $value->format('Y-m-d H:i:s');
        }
    }

    /*
     * Handle dates fields: convert timezones
     * @throws ValidationException
     */
    private function handleDates()
    {
        if ( ! $this->dates) {
            return;
        }

        foreach ($this->dates as $field) {
            $value = $this->data[$field];

            if (empty($value)) {
                // No value provided
                continue;
            }

            $isConverted = isset($this->convertedDates[$field]) ? $this->convertedDates[$field] : false;

            if ($isConverted) {
                // This values is already converted
                // Prevent double conversion
                continue;
            }

            try {
                if (is_string($value) && isset($this->data['timezone'])) {
                    // Use provided timezone field
                    // Build full DateTime object
                    $value = new \DateTime($value, new \DateTimeZone($this->data['timezone']));
                }

                if ($value instanceof \DateTime) {
                    // Explicitly convert to UTC
                    $value->setTimezone(new \DateTimeZone('UTC'));

                    // Use correct format
                    $this->data[$field] = $value->format('Y-m-d H:i:s');
                    continue;
                }
            }
            catch(\Exception $e) {
                // Convert all exceptions into our ValidationException
            }

            // No timezone field and not a DateTime object
            throw new ValidationException('You must either provide `timezone` field, or a DateTime object for a date field');
        }
    }

    protected static function validation() {}

}