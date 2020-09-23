<?php

declare (strict_types = 1);

namespace App\Domain\Transaction;

class Transaction
{
    private $id;

    private $payer;

    private $payee;

    private $amount;

    private $status;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPayer(int $payer)
    {
        $this->payer = $payer;
    }

    public function getPayer()
    {
        return $this->payer;
    }

    public function setPayee(int $payee)
    {
        $this->payee = $payee;
    }

    public function getPayee()
    {
        return $this->payee;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

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
