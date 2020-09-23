<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    protected $table = 'user_transactions';

    protected $fillable = ['status','payer','payee'];
}
