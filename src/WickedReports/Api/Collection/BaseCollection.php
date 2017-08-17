<?php

namespace WickedReports\Api\Collection;

use Countable;
use ArrayAccess;
use JsonSerializable;
use WickedReports\Api\Item\BaseItem;
use WickedReports\Exception\ValidationException;

abstract class BaseCollection implements ArrayAccess, Countable, JsonSerializable {

    /**
     * @var string Collection item class
     */
    protected static $itemClass;

    /**
     * @var BaseItem[] Collection items
     */
    protected $items = [];

    /**
     * BaseCollection constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        if (count($items) > 0) {
            $this->setItems($this->hydrate($items, static::$itemClass));
        }
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @throws ValidationException
     */
    public function setItems(array $items)
    {
        // Check whether passed items is array of arrays / item objects
        $firstItem = $items[key($items)];

        if (isset($firstItem) && ! is_array($firstItem) && ! $firstItem instanceof static::$itemClass) {
            throw new ValidationException('Collection must be an array of arrays/objects');
        }

        $this->items = $items;
        $this->checkCollectionSize();
    }

    /**
     * Convert array items into object items
     * @param array $items
     * @param string $className
     * @return array
     */
    public function hydrate (array $items, $className)
    {
        return array_map(function($item) use ($className) {
            if (is_array($item)) {
                // Convert raw array item into object
                /** @var BaseItem $item */
                $item = new $className($item);

                // Test item data immediately
                $item->validate();
            }

            return $item;
        }, $items);
    }

    /**
     * Create a new collection instance if the value isn't one already
     * @param  mixed  $items
     * @return static
     */
    public static function make($items = [])
    {
        return new static($items);
    }

    /**
     * Get all of the items in the collection
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get an item from the collection by key
     * @param  mixed  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Determine if an item exists in the collection by key
     * @param  mixed  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Determine if the collection is empty or not
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Get the keys of the collection items
     * @return static
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * Count the number of items in the collection
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Determine if an item exists at an offset
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if ( ! $value instanceof static::$itemClass) {
            // Convert to item type
            $value = new static::$itemClass($value);
        }

        if (is_null($key)) {
            $this->items[] = $value;
        }
        else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the collection to its string representation
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this);
    }

    /**
     * Convert array of object into array of arrays
     * @return array
     */
    public function toPlainArray()
    {
        return array_map(function($item) {
            /** @var $item BaseItem */
            return $item->toArray();
        }, $this->items);
    }

    /**
     * @throws ValidationException
     */
    private function checkCollectionSize()
    {
        if (count($this->items) < 1 OR count($this->items) > 1000) {
            throw new ValidationException('Collection must be from 1 to 1000 items');
        }
    }

}