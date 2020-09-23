<?php

use App\Domain\User\UserModel;

class TransactionTest extends TestCase {

    public function testShouldValidate_WhenAllInfoIsCorrect()
    {
        $payer = UserModel::where('type','F')->first()->toArray();
        $payee = UserModel::where('id','<>',$payer['id'])->first();

        $response = $this->call('POST', '/transaction',[
            "payer" => $payer['id'],
            "payee" => $payee['id'],
            "value" => 10,
        ]);

        $this->assertEquals(201, $response->status());
    }

    public function testShouldNotValidate_WhenPayerDoesntExists()
    {
        $payee = UserModel::first()->toArray();

        $response = $this->call('POST', '/transaction',[
            "payer" => 0,
            "payee" => $payee['id'],
            "value" => 10,
        ]);

        $this->assertEquals(400, $response->status());
    }

    public function testShouldNotValidate_WhenPayeeDoesntExists()
    {
        $payer = UserModel::first()->toArray();

        $response = $this->call('POST', '/transaction',[
            "payer" => $payer['id'],
            "payee" => 0,
            "value" => 10,
        ]);

        $this->assertEquals(400, $response->status());
    }

    public function testShouldNotValidate_WhenPayerisStore()
    {
        $payer = UserModel::where('type','J')->first()->toArray();

        $payee = UserModel::where('id','<>',$payer['id'])->first();

        $response = $this->call('POST', '/transaction',[
            "payer" => $payer['id'],
            "payee" => $payee['id'],
            "value" => 10,
        ]);

        $this->assertEquals(400, $response->status());
    }

    public function testShouldNotValidate_WhenPayerisTheSameAsPayee()
    {
        $user = UserModel::first()->toArray();
        $response = $this->call('POST', '/transaction',[
            "payer" => $user['id'],
            "payee" => $user['id'],
            "value" => 10,
        ]);

        $this->assertEquals(400, $response->status());
    }

    public function testShouldNotValidate_WhenValueIsNull()
    {
        $payer = UserModel::first()->toArray();

        $payee = UserModel::where([
            ['id','<>',$payer['id']],
            ['type','=','F']
        ])->first();

        $response = $this->call('POST', '/transaction',[
            "payer" => $payer['id'],
            "payee" => $payee['id'],
            "value" => null,
        ]);

        $this->assertEquals(400, $response->status());
    }
}
