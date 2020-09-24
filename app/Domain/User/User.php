<?php

declare (strict_types = 1);

namespace App\Domain\User;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fullname;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var float
     */
    private $wallet = 0;

    /**
     * @param int $id
     */
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
     * @param string $fullname
     */
    public function setFullName(string $fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullname;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $cpf
     */
    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj(string $cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return string
     */
    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param float $wallet
     */
    public function setWallet(float $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return float
     */
    public function getWallet(): float
    {
        return $this->wallet;
    }

    /**
     * @return boolean
     */
    public function isStore(): bool
    {
        return ($this->type == 'J' ? true : false);
    }

    /**
     * Preenche os atributos.
     *
     * @param \array $userData
     * @return User
     */
    public function fill(array $userData): User
    {
        if (isset($userData['id'])) {
            $this->setId($userData['id']);
        }

        if (isset($userData['fullname'])) {
            $this->setFullName($userData['fullname']);
        }

        if (isset($userData['type'])) {
            $this->setType($userData['type']);
        }

        if (isset($userData['cpf'])) {
            $this->setCpf($userData['cpf']);
        }

        if (isset($userData['cnpj'])) {
            $this->setCnpj($userData['cnpj']);
        }

        if (isset($userData['email'])) {
            $this->setEmail($userData['email']);
        }

        if (isset($userData['password'])) {
            $this->setPassword($userData['password']);
        }

        if (isset($userData['wallet'])) {
            $this->setWallet((float) $userData['wallet']);
        }

        return $this;
    }

    /**
     * Increases user's wallet after a transfer success.
     *
     * @return void
     */
    public function increaseWallet(float $value)
    {
        $this->wallet = $this->wallet + $value;
    }

    /**
     * Decreases user's wallet after a transfer fails.
     *
     * @return void
     */
    public function decreaseWallet(float $value)
    {
        $this->wallet = $this->wallet - $value;
    }
}
