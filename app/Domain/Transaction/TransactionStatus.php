<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

use App\Domain\Transaction\Exceptions\TransactionStatusNotFoundException;

/**
 * Classe responsável por manipular os
 * status das transações.
 */
class TransactionStatus
{
    const PENDING = '0';

    const APPROVED = '1';

    const REFUSED = '2';

    /**
     * Retorna o nome baseado no
     * número do status.
     *
     * @param string $code
     * @throws TransactionStatusNotFoundException
     * @return string
     */
    public static function getStatus(string $code): string
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
