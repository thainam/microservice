<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

use App\Domain\Transaction\TransactionModel;
use App\Domain\Transaction\Transaction;

interface TransactionRepositoryInterface
{
    public function __construct(TransactionModel $transactionModel);
    public function create(Transaction $transaction);
    public function update(Transaction $transaction, int $id);
    public function findById(int $id);
    public function getAll();
}
