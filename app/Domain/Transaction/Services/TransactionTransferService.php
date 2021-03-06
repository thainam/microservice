<?php

namespace App\Domain\Transaction\Services;

use App\Domain\Transaction\{
    Exceptions\TransactionAuthorizeException,
    Exceptions\TransactionTransferException,
    TransactionRepository,
    Transaction,
    TransactionModel,
    TransactionStatus,
};
use App\Domain\User\{UserModel, UserRepository};
use Illuminate\Support\Facades\{Log, Queue};
use App\Jobs\SendNotificationEmailJob;

/**
 * Classe responsável por processar
 * as transações.
 */
class TransactionTransferService  {

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var float
     */
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

    /**
     * Processa a transação.
     *
     * @throws TransactionTransferException|TransactionAuthorizeException
     * @return TransactionModel
     */
    public function handle(): TransactionModel
    {
        if ($this->payer->isStore()) {
            throw new TransactionTransferException('Lojistas não podem efetuar pagamento.', 400);
        }

        if ($this->payer->getWallet() < $this->amount) {
            throw new TransactionTransferException('Saldo insuficiente para realizar o pagamento.', 400);
        }

        try {
            $this->createTransaction();

            $this->decreasePayerWallet();

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

    /**
     * Cria instância da nova transação.
     *
     * @return int
     */
    public function createTransaction(): int
    {
        $this->transaction->fill([
            'payer' => $this->payer->getId(),
            'payee' => $this->payee->getId(),
            'amount' => $this->amount,
            'status' => TransactionStatus::PENDING
        ]);

        return $this->transactionId = $this->transactionRepository->create($this->transaction);
    }

    /**
     * Efetua o débito na carteira
     * do usuário pagador.
     *
     * @return void
     */
    private function decreasePayerWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->decreaseWallet($this->payer->getId(), $this->amount);
    }

    /**
     * Efetua o crédito na carteira
     * do usuário pagador.
     *
     * @return void
     */
    private function increasePayeeWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->increaseWallet($this->payee->getId(), $this->amount);
    }

    /**
     * Efetua o estorno na carteira
     * do usuário pagador.
     *
     * @return void
     */
    private function chargebackPayerWallet()
    {
        $repository = new UserRepository($this->userModel);
        $repository->increaseWallet($this->payer->getId(), $this->amount);
    }
}
