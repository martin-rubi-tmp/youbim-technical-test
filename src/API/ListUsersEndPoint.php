<?php

namespace Youbim\API;

use Youbim\Collections\UsersCollection;

class ListUsersEndPoint extends EndPoint {
    public function evaluate($params = null)
    {
        $users = UsersCollection::all();

        return $this->response_with_success([
                "users" => $this->collect_users( $users )
            ]);
    }

    protected function collect_users($users)
    {
        return array_map( function($each_user) {
                return [
                    "name" => $each_user->get_name(),
                    "last_name" => $each_user->get_last_name(),
                    "email" => $each_user->get_email(),
                    "phone_number" => $each_user->get_phone_number(),
                ];
            },
            $users
        );
    }
}
