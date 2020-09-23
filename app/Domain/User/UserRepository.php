<?php

namespace App\Domain\User;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserModel;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $model;

    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param User $transaction
     * @param int $id
     * @throws UserNotFoundException
     * @return void
     */
    public function update(User $user, int $id): void
    {
        $userModel = $this->model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }
        $userModel->wallet = $user->getWallet() ?? $userModel->wallet;
        $userModel->save();
    }

    /**
     * Busca uma usuário pelo ID.
     *
     * @param int $id
     * @return UserModel
     */
    public function findById(int $id): User
    {
        $userModel = $this->model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }
        return (new User())->fill($userModel->toArray());
    }

    /**
     * Busca todas os usuários no sistema.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection
    {
       return $this->model->all();
    }

    /**
     * Efetua um débido da carteira
     * de um determinado usuário.
     *
     * @param int $id
     * @param float $amount
     * @throws UserNotFoundException
     * @return void
     */
    public function decreaseWallet(int $id, float $amount): void
    {
        $model = $this->model;
        $userModel = $model->find($id);
        if (!$userModel) {
            throw new UserNotFoundException();
        }

        $userModel->wallet -= $amount;
        $userModel->save();
    }

    /**
     * Efetua um crédito na carteira
     * de um determinado usuário.
     *
     * @param int $id
     * @param float $amount
     * @throws UserNotFoundException
     * @return void
     */
    public function increaseWallet(int $id, float $amount): void
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
