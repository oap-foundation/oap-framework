<?php

namespace OAP\Payment\Model;

class Money
{
    private int $amount; // In cents
    private string $currency; // ISO 4217

    public function __construct(int $amount, string $currency)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException("Amount cannot be negative");
        }
        $this->amount = $amount;
        $this->currency = strtoupper($currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function toArray(): array
    {
        return [
            'value' => (string) ($this->amount / 100), // Format as decimal string for JSON-LD
            'currency' => $this->currency
        ];
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['value']) || !isset($data['currency'])) {
            throw new \InvalidArgumentException("Invalid Money array format");
        }
        // Convert decimal string back to cents
        $amount = (int) (floatval($data['value']) * 100);
        return new self($amount, $data['currency']);
    }
}
