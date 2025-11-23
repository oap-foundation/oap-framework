<?php

namespace OAP\Commerce\Messages;

class OrderConfirmation
{
    public string $orderId;
    public string $status;
    public array $paymentRequest;

    public function __construct(string $orderId, string $status, array $paymentRequest)
    {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->paymentRequest = $paymentRequest;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'OrderConfirmation',
            'orderId' => $this->orderId,
            'status' => $this->status,
            'paymentRequest' => $this->paymentRequest
        ];
    }
}
