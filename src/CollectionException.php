<?php

namespace Antares\Collection;

use \Exception;

class CollectionException extends Exception
{
    /**
     * Create a new exception for not defined item type
     *
     * @return static
     */
    public static function forNotDefinedItemType()
    {
        return new static("Item type not defined.");
    }

    /**
     * Create a new exception for non existent type
     *
     * @param  string  $type
     * @return static
     */
    public static function forNonExistentType($type)
    {
        return new static("Non existent type: {$type}.");
    }

    /**
     * Create a new exception for invalid type
     *
     * @param  string  $collectionType
     * @param  string  $type
     * @return static
     */
    public static function forInvalidType($collectionType, $type)
    {
        return new static("The collection type '${collectionType}' cannot have item of type '{$type}'.");
    }

    /**
     * Create a new exception for no item supplied
     *
     * @return static
     */
    public static function forNoItemSupplied()
    {
        return new static("No item supplied.");
    }

    /**
     * Create a new exception for not defined id
     *
     * @return static
     */
    public static function forNotDefinedId()
    {
        return new static("Item ID not defined.");
    }

    /**
     * Create a new exception for already defined id
     * 
     * @param  mixed  $id
     * @return static
     */
    public static function forAlreadyDefinedId($id)
    {
        return new static("Already defined ID: {$id}.");
    }

    /**
     * Create a new exception for not found id
     * 
     * @param  mixed  $id
     * @return static
     */
    public static function forNotFoundId($id)
    {
        return new static("Not found ID: '{$id}'.");
    }

    /**
     * Create a new exception for change id property attenpt
     *
     * @param  string  $id
     * @return static
     */
    public static function forChangeIdPropertyAttempt($id)
    {
        return new static("Change ID property attempt: '{$id}'.");
    }

}
