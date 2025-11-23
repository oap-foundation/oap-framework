<?php

namespace OAP\Core\Trust;

use OAP\Core\Security\KeyProviderInterface;

interface VerifiableCredentialHandlerInterface
{
    public function verify(string $vcJson, string $issuerDid): VerificationResult;
    public function issue(array $claims, KeyProviderInterface $issuerKey): string;
}
