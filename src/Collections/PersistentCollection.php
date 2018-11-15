<?php

namespace Youbim\Collections;


/**
 * Defines the protocol for subclasses acting as persistent collections of objects.
 * They usually will be wrappers to databases.
 */
abstract class PersistentCollection {

    /**
     * Returns the name of the collection.
     */
    abstract public function get_collection_name();

    /**
     * Returns the last item in the collection.
     */
    abstract public function last();

    /**
     * Truncates the collection, deleting all its items.
     */
    abstract public function truncate();

    /**
     * Adds the $object to this PersistentCollection.
     */
    abstract public function add($object);
}