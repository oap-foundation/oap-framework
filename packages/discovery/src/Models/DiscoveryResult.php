<?php

namespace OAP\Discovery\Models;

class DiscoveryResult
{
    public string $did;
    public string $endpointUrl;
    public array $capabilities;
    public TrustMetadata $trust;

    public function __construct(string $did, string $endpointUrl, array $capabilities, TrustMetadata $trust)
    {
        $this->did = $did;
        $this->endpointUrl = $endpointUrl;
        $this->capabilities = $capabilities;
        $this->trust = $trust;
    }
}
