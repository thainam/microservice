<?php

declare (strict_types = 1);

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\TransactionModel;
use App\Domain\Transaction\TransactionStoreRequest;
use Illuminate\Http\Request;

/**
 * Classe para manipular a solicitação
 * de nova transação.
 */
class TransactionService  {

    /**
     * @var TransactionStoreRequest
     */
    private $transactionStoreRequest;

    public function __construct(TransactionStoreRequest $transactionStoreRequest)
    {
        $this->transactionStoreRequest = $transactionStoreRequest;
    }

    /**
     * @param Request $request
     * @throws ValidationException
     * @return TransactionModel
     */
    public function handle(Request $request): TransactionModel
    {
        try {

            $this->transactionStoreRequest::validate($request);

            $transactionTransferService = new TransactionTransferService($request->payer, $request->payee, $request->value);

            return $transactionTransferService->handle();

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }
}
