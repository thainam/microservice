<?php

declare (strict_types = 1);

namespace App\Domain\User;

use App\Domain\User\{UserModel, User};

interface UserRepositoryInterface
{
    public function __construct(UserModel $userModel);
    public function update(User $user, int $id);
    public function findById(int $id);
    public function getAll();
}
