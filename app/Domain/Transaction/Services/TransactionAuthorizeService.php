<?php

declare (strict_types = 1);

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\Exceptions\TransactionAuthorizeException;
use \GuzzleHttp\Client as GuzzleHttpClient;

/**
 * Classe responsável por consultar
 * o serviço externo de autorização.
 */
class TransactionAuthorizeService
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleHttpClient;

    /**
     * Link do serviço autorizador.
     */
    const AUTHORIZATION_LINK = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function __construct()
    {
        $this->guzzleHttpClient = new GuzzleHttpClient();
    }

    /**
     * Faz a requisição ao serviço.
     *
     * @param float $amount
     * @throws TransactionAuthorizeException
     * @return boolean|null
     */
    public function getAuthorization(float $amount): ?bool
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
