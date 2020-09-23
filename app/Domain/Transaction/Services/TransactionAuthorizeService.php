<?php

declare (strict_types = 1);

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\Exceptions\TransactionAuthorizeException;
use \GuzzleHttp\Client as GuzzleHttpClient;

class TransactionAuthorizeService
{
    private $guzzleHttpClient;

    const AUTHORIZATION_LINK = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function __construct()
    {
        $this->guzzleHttpClient = new GuzzleHttpClient();
    }

    public function getAuthorization(float $amount)
    {
        try {
            $response = $this->guzzleHttpClient->request('POST', self::AUTHORIZATION_LINK, ['json' => ['amount' => $amount]]);
        } catch (\Exception $e) {
            throw new TransactionAuthorizeException('Erro na autorização, houve uma falha na comunicação com o autorizador.');
        }

        if ($response->getStatusCode() != 200) {
            throw new TransactionAuthorizeException('Transação não autorizada.');
        }

        return true;
    }
}
