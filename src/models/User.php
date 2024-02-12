<?php

namespace app\reminder\models;


class User
{
    public $name;
    public $day;

    public function __construct(array $data)
    {
        $this->name = $data[0];
        $this->day = empty($data[1]) ? 1 : 2;
    }
}