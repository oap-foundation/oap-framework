<?php

namespace OAP\Transport;

use OAP\Transport\Adapters\TransportAdapterInterface;
use OAP\Transport\Adapters\HttpTransportAdapter;

class TransportFactory
{
    private array $adapters = [];

    public function __construct()
    {
        // Register default adapters
        $this->registerAdapter(new HttpTransportAdapter());
    }

    public function registerAdapter(TransportAdapterInterface $adapter): void
    {
        $this->adapters[] = $adapter;
    }

    public function getAdapterFor(string $url): ?TransportAdapterInterface
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->supports($url)) {
                return $adapter;
            }
        }
        return null;
    }
}
