<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_transactions';

    /**
     * @var array
     */
    protected $fillable = ['status','payer','payee','amount'];
}
