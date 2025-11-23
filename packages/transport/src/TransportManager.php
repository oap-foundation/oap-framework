<?php

namespace OAP\Transport;

use OAP\Core\Identity\DIDResolverInterface;
use OAP\Transport\Exceptions\ResolutionException;
use OAP\Transport\Exceptions\UnreachableAgentException;

class TransportManager
{
    private DIDResolverInterface $didResolver;
    private TransportFactory $factory;

    public function __construct(DIDResolverInterface $didResolver, TransportFactory $factory)
    {
        $this->didResolver = $didResolver;
        $this->factory = $factory;
    }

    /**
     * @throws ResolutionException
     * @throws UnreachableAgentException
     * @throws \OAP\Transport\Exceptions\OAPTransportException
     */
    public function send(string $targetDid, string $payload): TransportResponse
    {
        // 1. Resolve DID
        $didDoc = $this->didResolver->resolve($targetDid);
        if (!$didDoc) {
            throw new ResolutionException("Could not resolve DID: $targetDid");
        }

        // 2. Get Endpoint
        // We look for 'OACP' type endpoint as per standard, or generic 'OAPServiceEndpoint'
        $endpointUrl = $didDoc->getServiceEndpoint('OACP');
        if (!$endpointUrl) {
            // Fallback to generic if OACP specific not found
            $endpointUrl = $didDoc->getServiceEndpoint('OAPServiceEndpoint');
        }

        if (!$endpointUrl) {
            throw new ResolutionException("No suitable service endpoint found for DID: $targetDid");
        }

        // 3. Find Adapter
        $adapter = $this->factory->getAdapterFor($endpointUrl);
        if (!$adapter) {
            throw new ResolutionException("No adapter found supporting endpoint: $endpointUrl");
        }

        // 4. Dispatch
        return $adapter->dispatch($endpointUrl, $payload);
    }
}
