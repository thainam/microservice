<?php

namespace App\Http\Controllers;

use App\Domain\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    /**
     * Solicita os usuários do sistema.
     *
     * @param UserRepository $userRepository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(UserRepository $userRepository): Collection
    {
        return $userRepository->getAll();
    }
}
