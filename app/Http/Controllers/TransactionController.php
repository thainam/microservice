<?php

namespace App\Http\Controllers;

use App\Domain\Transaction\Exceptions\TransactionStoreRequestException;
use App\Domain\Transaction\Exceptions\TransactionTransferException;
use App\Domain\Transaction\Services\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Classe responsável por intermediar
 * a solicitação de nova transação do usuário.
 */
class TransactionController extends Controller
{
    /**
     * Solicita a criação de uma nova transação.
     *
     * @param Request $request
     * @param TransactionService $transactionService
     * @throws TransactionTransferException|TransactionStoreRequestException
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function create(Request $request, TransactionService $transactionService)
    {
        try {

            $data = $transactionService->handle($request);

            return response()->json(['message' => 'Transação realizada com sucesso!', 'data' => $data], 201);

        } catch (TransactionTransferException $t) {
            return response()->json(['message' => $t->getMessage()], $t->getCode());
        } catch (TransactionStoreRequestException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
