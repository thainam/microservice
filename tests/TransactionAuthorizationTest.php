<?php

use App\Domain\Transaction\Services\TransactionAuthorizeService;

class TransactionAuthorizeTest extends TestCase {

    public function testShouldValidate_WhenAuthorizationReturnsTrue()
    {
        $transactionAuthorizeService = (new TransactionAuthorizeService())->getAuthorization(10.00);

        $this->assertEquals(200, $transactionAuthorizeService);
    }

}
