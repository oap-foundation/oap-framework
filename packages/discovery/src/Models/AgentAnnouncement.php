<?php

namespace OAP\Discovery\Models;

class AgentAnnouncement
{
    public string $did;
    public array $capabilities;
    public array $serviceEndpoints;
    public string $proof;

    public function __construct(string $did, array $capabilities, array $serviceEndpoints, string $proof)
    {
        $this->did = $did;
        $this->capabilities = $capabilities;
        $this->serviceEndpoints = $serviceEndpoints;
        $this->proof = $proof;
    }
}
