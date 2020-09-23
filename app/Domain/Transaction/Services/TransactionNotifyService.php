<?php

declare (strict_types = 1);

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\Exceptions\TransactionNotifyException;
use \GuzzleHttp\Client as GuzzleHttpClient;

/**
 * Classe responsável por consultar
 * o serviço externo de notificação.
 */
class TransactionNotifyService
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleHttpClient;

    /**
     * Link do serviço de notificação.
     */
    const NOTIFICATION_LINK = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

    public function __construct()
    {
        $this->guzzleHttpClient = new GuzzleHttpClient();
    }

    /**
     * Faz a requisição ao serviço.
     *
     * @param int $payee
     * @throws TransactionNotifyException
     * @return boolean|null
     */
    public function sendNotification(int $payee): ?bool
    {
        try {
            $response = $this->guzzleHttpClient->request('POST', self::NOTIFICATION_LINK, ['json' => ['payee' => $payee]]);
        } catch (\Exception $e) {
            throw new TransactionNotifyException('Erro no envio, houve uma falha na comunicação com o serviço de notificação.');
        }

        if ($response->getStatusCode() != 200) {
            throw new TransactionNotifyException('Envio de notificação não autorizado.');
        }

        return true;
    }
}
