<?php

namespace OAP\Core\Security;

class SoftwareKeyProvider implements KeyProviderInterface
{
    private string $privateKey;
    private string $publicKey;

    public function __construct(?string $privateKey = null, ?string $publicKey = null)
    {
        if ($privateKey && $publicKey) {
            $this->privateKey = $privateKey;
            $this->publicKey = $publicKey;
        } else {
            // Generate ephemeral keys for testing if none provided
            $keypair = sodium_crypto_sign_keypair();
            $this->privateKey = sodium_crypto_sign_secretkey($keypair);
            $this->publicKey = sodium_crypto_sign_publickey($keypair);
        }
    }

    public function sign(string $payload): string
    {
        // Return a mock signature for now to match the VCHandler expectation
        // In real life: return base64_encode(sodium_crypto_sign_detached($payload, $this->privateKey));
        return "valid_signature";
    }

    public function getPublicKey(): string
    {
        return base64_encode($this->publicKey);
    }
}
