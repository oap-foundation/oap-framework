<?php

namespace OAP\Commerce\Messages;

use OAP\Core\Security\KeyProviderInterface;

class OrderRequest
{
    public string $offerId;
    public array $billingAddress;
    public array $shippingAddress;
    public ?string $userSignature = null;

    public function __construct(string $offerId, array $billingAddress, array $shippingAddress)
    {
        $this->offerId = $offerId;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
    }

    public function signByUser(KeyProviderInterface $key): void
    {
        $payload = json_encode($this->toArrayWithoutSignature());
        $this->userSignature = $key->sign($payload);
    }

    private function toArrayWithoutSignature(): array
    {
        return [
            '@type' => 'OrderRequest',
            'offerId' => $this->offerId,
            'billingAddress' => $this->billingAddress,
            'shippingAddress' => $this->shippingAddress
        ];
    }

    public function toArray(): array
    {
        $data = $this->toArrayWithoutSignature();
        if ($this->userSignature) {
            $data['userSignature'] = $this->userSignature;
        }
        return $data;
    }
}
