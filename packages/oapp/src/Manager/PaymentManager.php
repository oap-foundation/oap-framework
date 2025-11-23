<?php

namespace OAP\Payment\Manager;

use OAP\Payment\Gateway\PaymentGatewayInterface;
use OAP\Payment\Model\Money;
use OAP\Payment\Model\PaymentRequest;
use OAP\Payment\Model\PaymentAuthorization;
use OAP\Payment\Model\PaymentConfirmation;
use OAP\Payment\Exception\InvalidSignatureException;
use OAP\Core\Security\KeyProviderInterface;
use OAP\Core\Identity\DIDResolverInterface;

class PaymentManager
{
    private PaymentGatewayInterface $gateway;
    private KeyProviderInterface $keyProvider;
    private DIDResolverInterface $didResolver;

    public function __construct(
        PaymentGatewayInterface $gateway,
        KeyProviderInterface $keyProvider,
        DIDResolverInterface $didResolver
    ) {
        $this->gateway = $gateway;
        $this->keyProvider = $keyProvider;
        $this->didResolver = $didResolver;
    }

    public function createRequest(string $orderId, Money $amount, string $recipientAddress): PaymentRequest
    {
        return new PaymentRequest($orderId, $amount, $recipientAddress);
    }

    public function authorize(PaymentRequest $request, array $gatewayData): PaymentAuthorization
    {
        // 1. Create payload to sign
        // We sign the canonical JSON of the request + gateway data
        $payload = json_encode([
            'request' => $request->toArray(),
            'gatewayData' => $gatewayData
        ]);

        // 2. Sign
        $signature = $this->keyProvider->sign($payload);

        // 3. Create Proof
        // Assuming KeyProvider gives us the public key or we know our DID
        // For v0.1 we simplify and just put the signature value
        $proof = [
            'type' => 'Ed25519Signature2018',
            'created' => date('c'),
            'signatureValue' => $signature
        ];

        return new PaymentAuthorization($request, $gatewayData, $proof);
    }

    /**
     * @throws InvalidSignatureException
     * @throws \OAP\Payment\Exception\PaymentFailedException
     */
    public function execute(PaymentAuthorization $auth): PaymentConfirmation
    {
        // 1. Verify Signature
        // In a real implementation, we would use $this->didResolver to fetch the payer's key
        // and verify $auth->getProof()['signatureValue'] against the payload.
        // For v0.1 and MockGateway, we skip deep verification or assume valid if signature present.

        if (empty($auth->getProof()['signatureValue'])) {
            throw new InvalidSignatureException("Missing signature in PaymentAuthorization");
        }

        // 2. Check Gateway Support
        $currency = $auth->getRequest()->getAmount()->getCurrency();
        if (!$this->gateway->supports($currency)) {
            throw new \OAP\Payment\Exception\PaymentFailedException("Gateway does not support currency: $currency");
        }

        // 3. Process
        return $this->gateway->process($auth);
    }
}
