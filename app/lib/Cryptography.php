<?php

namespace App\Lib;

use Laminas\Crypt\Password\Bcrypt;

/**
 * Class Cryptography
 *
 * @package \App\Lib
 */
class Cryptography
{
    private $bcrypt;

    public $plainPass;

    public $encryptedPass;

    public function __construct()
    {
        $this->bcrypt = new Bcrypt();
    }

    public function encryptPassword(): ?string
    {
        $this->encryptedPass = $this->bcrypt->create($this->plainPass);

        return $this->encryptedPass;
    }

    public function verifyPassword(): ?bool
    {
        if ($this->bcrypt->verify($this->plainPass, $this->encryptedPass)) {
            return true;
        }

        return false;
    }
}