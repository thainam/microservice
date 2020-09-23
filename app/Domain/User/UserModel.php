<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{

    protected $table = 'users';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


}
