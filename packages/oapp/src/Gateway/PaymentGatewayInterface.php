<?php

namespace OAP\Payment\Gateway;

use OAP\Payment\Model\PaymentAuthorization;
use OAP\Payment\Model\PaymentConfirmation;
use OAP\Payment\Exception\PaymentFailedException;

interface PaymentGatewayInterface
{
    public function supports(string $currency): bool;

    /**
     * @throws PaymentFailedException
     */
    public function process(PaymentAuthorization $auth): PaymentConfirmation;

    public function verifyStatus(string $transactionId): string;
}
