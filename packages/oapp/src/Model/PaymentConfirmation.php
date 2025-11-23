<?php

namespace OAP\Payment\Model;

class PaymentConfirmation
{
    private string $transactionId;
    private string $status;
    private int $timestamp;

    public function __construct(string $transactionId, string $status, int $timestamp)
    {
        $this->transactionId = $transactionId;
        $this->status = $status;
        $this->timestamp = $timestamp;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'PaymentConfirmation',
            'transactionId' => $this->transactionId,
            'status' => $this->status,
            'timestamp' => date('c', $this->timestamp)
        ];
    }
}
