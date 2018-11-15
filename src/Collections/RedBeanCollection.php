<?php

namespace Youbim\Collections;

use RedBeanPHP\R;


/**
 * A RedBean implementation for reading and writting Users to a persistent database.
 */
abstract class RedBeanCollection extends PersistentCollection {

    /**
     * Setups the default RedBean connection used by subclasses
     */
    static public function setup_connection($connection_string, $user, $password)
    {
        R::setup( $connection_string, $user, $password );
        R::setAutoResolve( TRUE );
    }

    /**
     * Returns true if the connection has been stablished, false otherwise.
     */
    static public function is_connected()
    {
        return R::testConnection();
    }

    protected function table_name()
    {
        return $this->get_collection_name();
    }

    /**
     * Returns the last item in the collection.
     */
    public function last()
    {
        $record = R::findOne( $this->table_name(), " order by id desc ");

        return $this->map_reford_to_object( $record );
    }

    /**
     * Returns all the items the collection.
     */
    public function all()
    {
        $records = R::findAll( $this->table_name(), " order by id ");

        $object = array_map( function($each_record) {
                return $this->map_reford_to_object( $each_record );
            },
            $records
        );

        return array_values( $object );
    }

    /**
     * Truncates the collection, deleting all its items.
     */
    public function truncate()
    {
        R::exec( "truncate table {$this->table_name()};" );

        return $this;
    }

    /**
     * Adds the $object to this PersistentCollection.
     */
    public function add($object)
    {
        $record = R::dispense( $this->table_name() );

        $this->map_object_to_record($object, $record);

        $id = R::store( $record );

        $object->set_id( $id );

        return $this;
    }

    /**
     * Maps the $object to the redbean $record.
     */
    abstract protected function map_object_to_record($object, $record);

    /**
     * Maps the $record to a new object.
     */
    abstract protected function map_reford_to_object( $record );
}