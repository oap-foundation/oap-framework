<?php

namespace OAP\Discovery\Models;

class TrustMetadata
{
    public bool $hasVerifiedCredential;
    public array $issuers;
    public ?string $expirationDate;

    public function __construct(bool $hasVerifiedCredential, array $issuers = [], ?string $expirationDate = null)
    {
        $this->hasVerifiedCredential = $hasVerifiedCredential;
        $this->issuers = $issuers;
        $this->expirationDate = $expirationDate;
    }
}
