<?php

namespace Youbim\Collections;

use RedBeanPHP\R;

/**
 * A RedBean implementation for reading and writting Users to a persistent database.
 */
class RedBeanUsersCollection extends RedBeanCollection {

    /**
     * Returns the name of the collection.
     */
    public function get_collection_name()
    {
        return "users";
    }

    /**
     * Maps the $user to the redbean $record.
     */
    protected function map_object_to_record($user, $record)
    {
        if( $user->get_id() !=  null ){
            $record->id = $user->get_id();
        }

        $record->name = $user->get_name();
        $record->last_name = $user->get_last_name();
        $record->email = $user->get_email();
        $record->phone_number = $user->get_phone_number();
    }

    /**
     * Maps the $record to a new user.
     */
    protected function map_reford_to_object( $record )
    {
        $user = new \Youbim\Models\User();

        $user->set_id( $record->id );
        $user->set_name( $record->name );
        $user->set_last_name( $record->last_name );
        $user->set_email( $record->email );
        $user->set_phone_number( $record->phone_number );

        return $user;        
    }
}