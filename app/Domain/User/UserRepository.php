<?php

namespace App\Domain\User;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserModel;
use App\Domain\User\User;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }

    public function update(User $user, int $id)
    {
        $userModel = $this->model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }
        $userModel->wallet = $user->getWallet() ?? $userModel->wallet;
        $userModel->save();
    }

    public function findById(int $id)
    {
        $userModel = $this->model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }
        return (new User())->fill($userModel->toArray());
    }

    public function getAll()
    {
       return $this->model->all();
    }

    public function decreaseWallet(int $id, float $amount)
    {
        $model = $this->model;
        $userModel = $model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }

        $userModel->wallet -= $amount;
        $userModel->save();
    }

    public function increaseWallet(int $id, float $amount)
    {
        $model = $this->model;
        $userModel = $model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }

        $userModel->wallet += $amount;
        $userModel->save();
    }

}
