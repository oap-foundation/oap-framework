<?php

namespace OAP\Payment\Model;

class PaymentRequest
{
    private string $orderId;
    private Money $amount;
    private string $recipientAddress;

    public function __construct(string $orderId, Money $amount, string $recipientAddress)
    {
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->recipientAddress = $recipientAddress;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getRecipientAddress(): string
    {
        return $this->recipientAddress;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'PaymentRequest',
            'orderId' => $this->orderId,
            'amount' => $this->amount->toArray(),
            'recipientAddress' => $this->recipientAddress
        ];
    }
}
