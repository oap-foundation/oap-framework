<?php

namespace OAP\Payment\Model;

class PaymentAuthorization
{
    private PaymentRequest $request;
    private array $gatewayData; // Token, etc.
    private array $proof; // Signature

    public function __construct(PaymentRequest $request, array $gatewayData, array $proof)
    {
        $this->request = $request;
        $this->gatewayData = $gatewayData;
        $this->proof = $proof;
    }

    public function getRequest(): PaymentRequest
    {
        return $this->request;
    }

    public function getGatewayData(): array
    {
        return $this->gatewayData;
    }

    public function getProof(): array
    {
        return $this->proof;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'PaymentAuthorization',
            'orderId' => $this->request->getOrderId(),
            'amount' => $this->request->getAmount()->toArray(),
            'gatewayData' => $this->gatewayData,
            'proof' => $this->proof
        ];
    }
}
