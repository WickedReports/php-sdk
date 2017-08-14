<?php

namespace WickedReports\Api\Item;

use JsonSerializable;
use Respect\Validation\Exceptions\NestedValidationException;
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
     * BaseItem constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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

        $this->handleDates();
        $this->validate();
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

        $this->handleDates();
        $this->validate();
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

        if ( ! $validation instanceof \Respect\Validation\Validator) {
            throw new ValidationException('Validation should be instance of \Respect\Validation\Validator');
        }

        try {
            $validation->assert($this->getData());
        }
        catch (NestedValidationException $e) {
            throw new ValidationException(implode("\n", $e->getMessages()), 0, $e);
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

            // No timezone field and not a DateTime object
            throw new ValidationException('You must either provide `timezone` field, or a \\DateTime object for CreateDate/PaymentDate/etc field');
        }
    }

    protected static function validation() {}

}