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

    public function __construct()
    {
        $this->bcrypt = new Bcrypt();
    }

    public function encryptPassword($plainPass): ?string
    {
        return $this->bcrypt->create($plainPass);
    }

    public function verifyPassword($plainPass, $encryptedPass): ?bool
    {
        if ($this->bcrypt->verify($plainPass, $encryptedPass)) {
            return true;
        }

        return false;
    }
}