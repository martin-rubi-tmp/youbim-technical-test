<?php

namespace Youbim\Models;

class User
{
    protected $id;
    protected $name;
    protected $last_name;
    protected $email;
    protected $phone_number;

    public function __construct($name = null, $last_name = null, $email = null, $phone_number = null)
    {
        $this->id = null;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function get_last_name()
    {
        return $this->last_name;
    }

    public function set_last_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function set_email($email)
    {
        $this->email = $email;

        return $this;
    }

    public function get_phone_number()
    {
        return $this->phone_number;
    }

    public function set_phone_number($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}
