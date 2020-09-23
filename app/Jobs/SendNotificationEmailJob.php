<?php

namespace App\Jobs;

use App\Domain\Transaction\Exceptions\TransactionNotifyException;
use App\Domain\Transaction\Services\TransactionNotifyService;
use Illuminate\Support\Facades\Log;

class SendNotificationEmailJob extends Job
{
    private $payee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $payee)
    {
        $this->payee = $payee;
    }

    /**
     * Execute the notify service job.
     *
     * @return void
     */
    public function handle()
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
