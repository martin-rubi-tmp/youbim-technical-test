<?php

namespace Youbim\API;

use Youbim\Models\User;
use Youbim\Collections\UsersCollection;
use Respect\Validation\Validator as v;

/**
 * Defines the protocol for Youbim API. This protocol may be called from the controllers of web servers.
 */
class CreateUserEndPoint extends EndPoint {
    protected function validate($validator, $params)
    {
        return $validator->validate($params, [
            'user'                  => 'required',
            'user.name'             => 'required|max:32|alpha_dash',
            'user.last_name'        => 'required|max:32|alpha_dash',
            'user.email'            => 'required|max:128|email',
            'user.phone_number'     => 'required|max:32',
        ]);
    }

    public function evaluate($params = null)
    {
        if( $this->has_validation_errors( $params ) ) {
            return $this->response_with_errors( $this->validation_errors );
        }

        $user = new User(
            $params["user"]["name"],
            $params["user"]["last_name"],
            $params["user"]["email"],
            $params["user"]["phone_number"]
        );

        $created_user = UsersCollection::add( $user );

        return $this->response_with_success( [] );
    }
}
