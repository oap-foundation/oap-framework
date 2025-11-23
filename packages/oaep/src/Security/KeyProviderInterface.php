<?php

namespace OAP\Core\Security;

interface KeyProviderInterface
{
    public function sign(string $payload): string;
    public function getPublicKey(): string;
}
