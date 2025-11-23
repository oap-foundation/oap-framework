<?php

namespace OAP\Commerce\Messages;

class OfferResponse
{
    public array $product;
    public array $price;
    public string $validUntil;
    public array $credentials;

    public function __construct(array $product, array $price, string $validUntil, array $credentials = [])
    {
        $this->product = $product;
        $this->price = $price;
        $this->validUntil = $validUntil;
        $this->credentials = $credentials;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'OfferResponse',
            'product' => $this->product,
            'price' => $this->price,
            'validUntil' => $this->validUntil,
            'credentials' => $this->credentials
        ];
    }
}
