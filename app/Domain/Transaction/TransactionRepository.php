<?php

namespace App\Domain\Transaction;

use App\Domain\Transaction\Exceptions\TransactionNotFoundException;

class TransactionRepository implements TransactionRepositoryInterface
{
    private $model;

    public function __construct(TransactionModel $transactionModel)
    {
        $this->model = $transactionModel;
    }

    public function create(Transaction $transaction)
    {
        $transactionModel = $this->model;

        $transactionModel->payer = $transaction->getPayer();
        $transactionModel->payee = $transaction->getPayee();
        $transactionModel->amount = $transaction->getAmount();
        $transactionModel->status = $transaction->getStatus();

        $transactionModel->save();

        return $transactionModel->id;
    }

    public function update(Transaction $transaction, int $id)
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

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function getAll()
    {
       return $this->model->all();
    }
}
