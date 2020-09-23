<?php

declare (strict_types = 1);

namespace App\Domain\Transaction\Exceptions;

use Exception;

class TransactionNotFoundException extends Exception
{
    public $message = 'Transação inexistente.';
}
