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

    public function login(): array
    {
        return ['success' => true];
    }

    public function getData(): array
    {
        return $this->db->select('users', [
            'id',
            'name',
            'email',
            'created_at'
        ], [
            'ORDER' => ['name' => 'ASC']
        ]);
    }

    public function register(): array
    {

    }
}