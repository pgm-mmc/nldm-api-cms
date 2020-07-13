<?php

namespace App\Data;

use App\Lib\Database;

/**
 * Class UserData
 * 
 * @package \App\Data
 */
class UserData extends Database
{

    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function login() : array
    {
        return ['success' => true];
    }

    public function register() : array
    {

    }
}