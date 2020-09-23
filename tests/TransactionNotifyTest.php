<?php

use App\Domain\Transaction\Services\TransactionNotifyService;
use App\Domain\User\UserModel;

class TransactionNotifyTest extends TestCase {

    public function testShouldValidate_WhenAuthorizationReturnsTrue()
    {
        $payee = UserModel::first();
        $transactionNotifyService = (new TransactionNotifyService())->sendNotification($payee['id']);
        $this->assertEquals(200, $transactionNotifyService);
    }

}
