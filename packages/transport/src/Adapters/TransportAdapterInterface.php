<?php

namespace OAP\Transport\Adapters;

use OAP\Transport\TransportResponse;

interface TransportAdapterInterface
{
    public function supports(string $serviceEndpointUrl): bool;
    public function dispatch(string $url, string $payload): TransportResponse;
}
