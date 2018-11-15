<?php

namespace Youbim\API;

use Rakit\Validation\Validator;

abstract class EndPoint {

    protected $validation_errors;

    public function __construct()
    {
        $this->validation_errors = [];
    }

    protected function has_validation_errors($params)
    {
        $this->validation_errors = [];

        $validator = new Validator();

        $validation = $this->validate( $validator, $params );

        $this->validation_errors = $validation->errors()->toArray();

        return count( $this->validation_errors ) > 0;
    }

    abstract public function evaluate($params = null);


    protected function response_with_success($data)
    {
        return [
            "success" => true,
            "data" => $data
        ];
    }

    protected function response_with_errors($errors)
    {
        return [
            "success" => false,
            "errors" => $errors
        ];
    }
}