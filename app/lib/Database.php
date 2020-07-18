<?php

namespace App\Lib;

use Medoo\Medoo as DB;
use PDO;

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
        $config = $c->get('settings')['database'];

        $this->db = new DB([
            'database_type' => $config['type'],
            'database_name' => $config['name'],
            'server'        => $config['server'],
            'username'      => $config['username'],
            'password'      => $config['password'],

            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'port' => 3306,

            'logging' => false,
            'option' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ],
            'command' => [
                'SET SQL_MODE=ANSI_QUOTES'
            ]
        ]);
    }
}