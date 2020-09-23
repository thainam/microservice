<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'fullname',
        'type',
        'cpf',
        'cnpj',
        'email',
        'wallet'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
    ];


}
