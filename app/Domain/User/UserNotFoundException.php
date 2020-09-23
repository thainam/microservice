<?php

declare (strict_types = 1);

namespace App\Domain\User;

use Exception;

class UserNotFoundException extends Exception
{
    public $message = 'Usuário inexistente.';
}
