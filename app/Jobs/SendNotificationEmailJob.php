<?php

namespace App\Jobs;

use App\Domain\Transaction\Exceptions\TransactionNotifyException;
use App\Domain\Transaction\Services\TransactionNotifyService;
use Illuminate\Support\Facades\Log;

/**
 * Classe responsável por simular o
 * envio de uma notificação.
 */
class SendNotificationEmailJob extends Job
{
    /**
     * @var int
     */
    private $payee;

    /**
     * Cria uma nova instancia do Job.
     * @param int $payee
     *
     * @return void
     */
    public function __construct(int $payee)
    {
        $this->payee = $payee;
    }

    /**
     * Executa o serviço de notificação.
     *
     * @throws TransactionNotifyException
     * @return void
     */
    public function handle(): void
    {
        try {

            (new TransactionNotifyService())->sendNotification($this->payee);

            Log::info('Simulando disparo de notificação em fila!');

        } catch(\Exception $e) {
            Log::error('Falha na execução da notificação: '.$e->getMessage());
            throw new TransactionNotifyException('Falha no serviço de notificação.');
        }
    }
}
