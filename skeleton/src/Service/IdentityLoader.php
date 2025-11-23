<?php

namespace OAP\Kernel\Service;

use OAP\Core\Security\SoftwareKeyProvider;

class IdentityLoader
{
    public static function loadKeyProvider(): SoftwareKeyProvider
    {
        $privateKey = $_ENV['AGENT_PRIVATE_KEY'] ?? null;
        $publicKey = $_ENV['AGENT_PUBLIC_KEY'] ?? null;

        // In a real app, we would decode these from hex/base64
        // For skeleton, we pass them through or let SoftwareKeyProvider generate ephemeral ones if missing
        return new SoftwareKeyProvider($privateKey, $publicKey);
    }
}
