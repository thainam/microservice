<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

use App\Domain\Transaction\Exceptions\TransactionStatusNotFoundException;

class TransactionStatus
{
    const PENDING = '0';

    const APPROVED = '1';

    const REFUSED = '2';

    public static function getStatus(string $code)
    {
        switch ($code) {
            case self::PENDING:
                return 'Pendente';
                break;
            case self::APPROVED:
                return 'Concluída';
                break;
            case self::REFUSED:
                return 'Cancelada';
                break;
        }
        throw new TransactionStatusNotFoundException('Código de status inexistente.');
    }
}
