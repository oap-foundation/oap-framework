<?php

namespace OAP\Payment\Gateway;

use OAP\Payment\Model\PaymentAuthorization;
use OAP\Payment\Model\PaymentConfirmation;
use OAP\Payment\Exception\PaymentFailedException;

class MockGatewayAdapter implements PaymentGatewayInterface
{
    public function supports(string $currency): bool
    {
        return true; // Mock supports everything
    }

    public function process(PaymentAuthorization $auth): PaymentConfirmation
    {
        // Simulate latency
        // sleep(1); // Commented out for faster tests

        $amount = $auth->getRequest()->getAmount()->getAmount();

        // Simulate failure for specific amount (e.g. 0 or negative, though Money prevents negative)
        if ($amount === 0) {
            throw new PaymentFailedException("Mock Gateway: Amount must be greater than 0");
        }

        // Simulate success
        $txId = "mock_tx_" . uniqid();
        return new PaymentConfirmation($txId, 'SUCCESS', time());
    }

    public function verifyStatus(string $transactionId): string
    {
        return 'SUCCESS';
    }
}
