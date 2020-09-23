<?php

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\Exceptions\TransactionAuthorizeException;
use App\Domain\Transaction\Exceptions\TransactionTransferException;
use App\Domain\Transaction\TransactionRepository;
use App\Domain\Transaction\Transaction;
use App\Domain\Transaction\TransactionModel;
use App\Domain\Transaction\TransactionStatus;
use App\Domain\User\UserModel;
use App\Domain\User\UserRepository;
use App\Jobs\SendNotificationEmailJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class TransactionTransferService  {

    private $transactionRepository;
    private $amount;

    public function __construct(int $payer, int $payee, float $amount)
    {
        $this->userModel = new UserModel();

        $transactionModel = new TransactionModel();

        $this->transactionRepository = (new TransactionRepository($transactionModel));
        $this->transaction = new Transaction();

        $this->payer = (new UserRepository($this->userModel))->findById($payer);
        $this->payee = (new UserRepository($this->userModel))->findById($payee);

        $this->amount = $amount;
    }

    public function handle()
    {
        if ($this->payer->isStore()) {
            throw new TransactionTransferException('Lojistas não podem efetuar pagamento.', 400);
        }

        if ($this->payer->getWallet() < $this->amount) {
            throw new TransactionTransferException('Saldo insuficiente para realizar o pagamento.', 400);
        }

        try {
            $this->createTransaction();

            (new TransactionAuthorizeService())->getAuthorization($this->amount);

            $this->transaction->setStatus(TransactionStatus::APPROVED);

            $this->transactionRepository->update($this->transaction, $this->transactionId);

            $this->increasePayeeWallet();

            Queue::push(new SendNotificationEmailJob($this->payee->getId()));

            return $this->transactionRepository->findById($this->transactionId);

        } catch (TransactionAuthorizeException $e) {

            $this->transaction->setStatus(TransactionStatus::REFUSED);

            $this->transactionRepository->update($this->transaction, $this->transactionId);

            $this->chargebackPayerWallet();

            Log::error('Falha na autorização da transação: '.$e->getMessage());

            throw new TransactionTransferException('Transação não autorizada.', 400);
        }
    }

    public function createTransaction()
    {
        $this->transaction->fill([
            'payer' => $this->payer->getId(),
            'payee' => $this->payee->getId(),
            'amount' => $this->amount,
            'status' => TransactionStatus::PENDING
        ]);

        $this->decreasePayerWallet();

        return $this->transactionId = $this->transactionRepository->create($this->transaction);
    }

    private function decreasePayerWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->decreaseWallet($this->payer->getId(), $this->amount);
    }

    private function increasePayeeWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->increaseWallet($this->payee->getId(), $this->amount);
    }

    private function chargebackPayerWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->increaseWallet($this->payer->getId(), $this->amount);
    }
}
