<?php
declare (strict_types = 1);

namespace App\Domain\User;

class User
{
    private $id;
    private $name;
    private $type;
    private $cpf;
    private $cnpj;
    private $email;
    private $password;
    private $wallet = 0;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCnpj(string $cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setWallet(float $wallet)
    {
        $this->wallet = $wallet;
    }

    public function getWallet()
    {
        return $this->wallet;
    }

    public function isStore()
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

        if (isset($userData['name'])) {
            $this->setName($userData['name']);
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
