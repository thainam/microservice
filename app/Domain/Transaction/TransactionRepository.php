<?php

namespace App\Domain\Transaction;

use App\Domain\Transaction\Exceptions\TransactionNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var TransactionModel
     */
    private $model;

    public function __construct(TransactionModel $transactionModel)
    {
        $this->model = $transactionModel;
    }

    /**
     * Cria uma nova transação.
     *
     * @param Transaction $transaction
     * @return int
     */
    public function create(Transaction $transaction): int
    {
        $transactionModel = $this->model;

        $transactionModel->payer = $transaction->getPayer();
        $transactionModel->payee = $transaction->getPayee();
        $transactionModel->amount = $transaction->getAmount();
        $transactionModel->status = $transaction->getStatus();

        $transactionModel->save();

        return $transactionModel->id;
    }

    /**
     * Atualiza uma transação existente.
     *
     * @param Transaction $transaction
     * @param int $id
     * @throws TransactionNotFoundException
     * @return int
     */
    public function update(Transaction $transaction, int $id): void
    {
        $model = $this->model;
        $transactionModel = $model->find($id);
        if (!$transactionModel) {
            throw new TransactionNotFoundException();
        }

        $transactionModel->payer = $transaction->getPayer() ?? $transactionModel->payer;
        $transactionModel->payee = $transaction->getPayee() ?? $transactionModel->payee;
        $transactionModel->status = $transaction->getStatus() ?? $transactionModel->status;
        $transactionModel->amount = $transaction->getAmount() ?? $transactionModel->amount;
        $transactionModel->save();
    }

    /**
     * Busca uma transação pelo ID.
     *
     * @param int $id
     * @return TransactionModel
     */
    public function findById(int $id): TransactionModel
    {
        return $this->model->find($id);
    }

    /**
     * Busca todas as transações no sistema.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
       return $this->model->all();
    }
}
