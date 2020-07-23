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
    public $id;

    public $name;

    public $email;

    public $password;

    public $displayName;

    public $isAdmin;

    public $rememberToken;

    public $createdAt;

    public $updatedAt;

    public $loginCounter;

    public $isLock;

    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function login(): bool
    {
        $id = $this->db->get('users', 'id', [
            'email' => $this->email
        ]);

        if (empty($id)) {
            return false;
        }

        return true;
    }

    public function getPassword(): string
    {
        return $this->db->get('users', 'password', [
            'email' => $this->email
        ]);
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

    public function setData(): bool
    {
        try {
            $this->db->pdo->beginTransaction();

            $this->db->insert('users', [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'display_name' => $this->name,
                'is_admin' => $this->isAdmin
            ]);

            $this->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->db->pdo->rollback();
        }

        return false;
    }
}