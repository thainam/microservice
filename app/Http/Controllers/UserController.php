<?php

namespace App\Http\Controllers;

use App\Domain\User\UserRepository;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        return $userRepository->getAll();
    }
}
