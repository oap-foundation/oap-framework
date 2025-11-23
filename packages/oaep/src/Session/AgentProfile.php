<?php

namespace OAP\Core\Session;

class AgentProfile
{
    public string $did;
    public array $supportedProtocols;

    public function __construct(string $did, array $supportedProtocols = ['oacp'])
    {
        $this->did = $did;
        $this->supportedProtocols = $supportedProtocols;
    }
}
