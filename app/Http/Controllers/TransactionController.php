<?php

namespace App\Http\Controllers;

use App\Domain\Transaction\Exceptions\TransactionStoreRequestException;
use App\Domain\Transaction\Services\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Request $request, TransactionService $transactionService)
    {
        try {

            $data = $transactionService->handle($request);

            return response()->json(['message' => 'Transação realizada com sucesso!', 'data' => $data], 201);

        } catch (TransactionStoreRequestException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
