<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

class Transaction
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $payer;

    /**
     * @var int
     */
    private $payee;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $status;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $payer
     */
    public function setPayer(int $payer)
    {
        $this->payer = $payer;
    }

    /**
     * @return int
     */
    public function getPayer(): int
    {
        return $this->payer;
    }

    /**
     * @param int $payee
     */
    public function setPayee(int $payee)
    {
        $this->payee = $payee;
    }

    /**
     * @return int
     */
    public function getPayee(): int
    {
        return $this->payee;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Preenche o objeto.
     *
     * @param array $transactionData
     * @return Transaction
     */
    public function fill(array $transactionData)
    {
        if (isset($transactionData['id'])) {
            $this->setId($transactionData['id']);
        }

        $this->setPayer($transactionData['payer']);
        $this->setPayee($transactionData['payee']);
        $this->setAmount($transactionData['amount']);
        $this->setStatus($transactionData['status']);

        return $this;
    }
}
