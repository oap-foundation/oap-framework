<?php

namespace OAP\Core\Identity;

class DIDDocument
{
    private string $id;
    private array $verificationMethods;
    private array $serviceEndpoints;

    public function __construct(string $id, array $verificationMethods = [], array $serviceEndpoints = [])
    {
        $this->id = $id;
        $this->verificationMethods = $verificationMethods;
        $this->serviceEndpoints = $serviceEndpoints;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPublicKey(?string $keyId = null): ?string
    {
        // If keyId is null, return the first available key
        if ($keyId === null) {
            return $this->verificationMethods[0]['publicKeyMultibase'] ?? null;
        }

        foreach ($this->verificationMethods as $vm) {
            if ($vm['id'] === $keyId || $vm['id'] === $this->id . '#' . $keyId) {
                return $vm['publicKeyMultibase'];
            }
        }
        return null;
    }

    public function getServiceEndpoint(string $type): ?string
    {
        foreach ($this->serviceEndpoints as $service) {
            if ($service['type'] === $type) {
                return $service['serviceEndpoint'];
            }
        }
        return null;
    }
}
