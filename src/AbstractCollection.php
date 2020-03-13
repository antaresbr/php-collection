<?php

namespace Antares\Collection;

use ArrayIterator;
use Countable;
use IteratorAggregate;

abstract class AbstractCollection implements Countable, IteratorAggregate
{
    /**
     * Valid types for collectoin items
     */
    const VALID_TYPES = 'boolean,integer,double,float,string,array,callable,iterable,mixed';

    /**
     * The class name of the items
     *
     * @var string
     */
    private $type = null;

    /**
     * Flag to indicate whether the items array is associative or not
     *
     * @var boolean
     */
    private $associative;

    /**
     * The array with the items
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new instance of this object.
     *
     * @param  Class  $type
     * @return void
     */
    public function __construct($type, $associative = true)
    {
        if (empty($type)) {
            throw CollectionException::forNotDefinedItemType();
        }

        if (strpos(static::VALID_TYPES . ',', strtolower($type).',') !== false) {
            $this->type = strtolower($type);
        }
        else {
            if (class_exists($type)) {
                $this->type = $type;
            }
            else {
                throw CollectionException::forNonExistentType($type);
            }
        }

        $this->associative = $associative;
    }
    
    /**
     * Get items count
     *
     * @return integer
     */
    public function count() {
        return count($this->items);
    }

    /**
     * Get items count
     *
     * @return integer
     */
    public function getIterator() {
        return new ArrayIterator($this->items);
    }

    /**
     * Get collection type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Chick if this collection is empty
     *
     * @return boolean
     */
    public function isEmpty() {
        return ($this->count() == 0);
    }

    /**
     * Get associative flag
     *
     * @return boolean
     */
    public function isAssociative() {
        return $this->associative;
    }

    /**
     * Get items id list
     *
     * @return array
     */
    public function idList() {
        return array_keys($this->items);
    }

    /**
     * Check if id is a collection member
     *
     * @param  mixed $id
     * @param  boolean $throwException
     * @return boolean
     */
    public function hasId($id, $throwException = false) {
        if (empty($id)) {
            throw CollectionException::forNotDefinedId();
        }

        $r = $this->isAssociative() ? array_key_exists($id, $this->items) : (array_search($id, $this->items) !== false);

        if (!$r and $throwException) {
            throw CollectionException::forNotFoundId($id);
        }

        return $r;
    }

    /**
     * Validate item type
     *
     * @param  mixed $item
     * @return boolean
     */
    protected function validateItemType($item) {
        if ($this->type != 'mixed') {
            $type = gettype($item);
            
            if ($type == 'object') {
                if (!($item instanceof $this->type)) {
                    throw CollectionException::forInvalidType($this->type, $type);
                }
            }
            else {
                if ($type != $this->type) {
                    throw CollectionException::forInvalidType($this->type, $type);
                }
            }
        }

        return true;
    }

    /**
     * Clear collection
     *
     * @return void
     */
    protected function clear($item) {
        $this->items = [];
    }

    /**
     * Get items data itself
     *
     * @return array
     */
    protected function toArray() {
        return $this->items;
    }

    /**
     * Add collection item
     *
     * @param  mixed $id
     * @param  mixed $item
     * @return boolean
     */
    protected function _add($id, $item = null) {
        if ($this->hasId($id)) {
            throw CollectionException::forAlreadyDefinedId($id);
        }

        if ($this->isAssociative()) {
            $this->validateItemType($item);
            $this->items[$id] = $item;
        }
        else {
            $this->validateItemType($id);
            $this->items[] = $id;
        }

        return true;
    }

    /**
     * Add collection item if it not exists
     *
     * @param  mixed $id
     * @param  mixed $item
     * @return boolean
     */
    protected function _addIfNotExists($id, $item = null) {
        if (!$this->hasId($id)) {
            $this->_add($id, $item);
        }

        return true;
    }

    /**
     * Delete collection item
     *
     * @param  mixed $id
     * @return mixed
     */
    protected function _delete($id) {
        if (!$this->hasId($id)) {
            throw CollectionException::forNotFoundId($id);
        }

        if ($this->isAssociative()) {
            unset($this->items[$id]);
        }
        else {
            unset($this->items[array_search($id, $this->items)]);
        }
        return true;
    }

    /**
     * Delete collection item if id exists
     *
     * @param  mixed $id
     * @return mixed
     */
    protected function _deleteIfExists($id) {
        if ($this->hasId($id)) {
            $this->_delete($id);
        }

        return true;
    }

    /**
     * Get collection item
     *
     * @param  mixed $id
     * @return mixed
     */
    protected function _getById($id) {
        if (!$this->hasId($id)) {
            throw CollectionException::forNotFoundId($id);
        }

        return $this->items[$id];
    }

}
