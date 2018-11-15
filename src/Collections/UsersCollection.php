<?php

namespace Youbim\Collections;

/**
 * The pulib interface for reading and writting Users to a persistent database.
 */
class UsersCollection
{
    static protected $instance;

    /**
     * Configure the UsersCollection to use the ReadBean implementation.
     * Must be called before calling any other method.
     */
    static public function use_redbean_instance()
    {
        self::$instance = new RedBeanUsersCollection();
    }

    /**
     * Truncates the collection, deleting all its users.
     */
    static public function truncate()
    {
        return self::$instance->truncate();
    }

    /**
     * Truncates the collection, deleting all its users.
     */
    static public function add($user)
    {
        return self::$instance->add($user);
    }

    /**
     * Returns the last item in the collection.
     */
    static public function last()
    {
        return self::$instance->last();        
    }

    /**
     * Returns all the items the collection.
     */
    static public function all()
    {
        return self::$instance->all();        
    }
}

UsersCollection::use_redbean_instance();