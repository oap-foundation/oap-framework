<?php

namespace OAP\Core\Trust;

class VerificationResult
{
    public bool $isValid;
    public array $errors;
    public ?string $issuer;

    public function __construct(bool $isValid, array $errors = [], ?string $issuer = null)
    {
        $this->isValid = $isValid;
        $this->errors = $errors;
        $this->issuer = $issuer;
    }
}
