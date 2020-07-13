<?php

namespace App\Lib;

use Medoo\Medoo as DB;

/**
 * Class Database
 *
 * @package \App\Lib
 */
class Database
{
    protected $db;

    public function __construct($c)
    {
        $database = $c->get('settings')['database'];

        $this->db = new DB([
            'database_type' => $database['type'],
            'database_name' => $database['name'],
            'server'        => $database['server'],
            'username'      => $database['username'],
            'password'      => $database['password']
        ]);
    }
}