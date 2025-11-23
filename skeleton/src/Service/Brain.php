<?php

namespace OAP\Kernel\Service;

use OAP\Discovery\Services\DiscoveryService;
use OAP\Discovery\Interfaces\DiscoveryAdapterInterface;
use OAP\Core\Session\OAEPSession;
use OAP\Core\Identity\DIDResolverInterface;
use OAP\Core\Security\KeyProviderInterface;
use OAP\Core\Session\AgentProfile;
use OAP\Transport\TransportManager;
use OAP\Commerce\Transaction\CommerceTransaction;
use OAP\Kernel\Repository\TransactionRepositoryInterface;

class Brain
{
    private DiscoveryService $discovery;
    private OAEPSession $session;
    private TransportManager $transport;
    private TransactionRepositoryInterface $repository;
    private KeyProviderInterface $keyProvider;
    private DIDResolverInterface $didResolver;

    public function __construct(
        DiscoveryAdapterInterface $discoveryAdapter,
        OAEPSession $session, // In real DI, we'd need to factory this or bind it
        TransportManager $transport,
        TransactionRepositoryInterface $repository,
        KeyProviderInterface $keyProvider,
        DIDResolverInterface $didResolver
    ) {
        $this->discovery = new DiscoveryService($discoveryAdapter);
        $this->session = $session; // In Kernel we didn't explicitly bind OAEPSession, might need autowiring or fix Kernel
        $this->transport = $transport;
        $this->repository = $repository;
        $this->keyProvider = $keyProvider;
        $this->didResolver = $didResolver;
    }

    public function findAndNegotiate(array $criteria): array
    {
        // 1. Discovery
        $category = $criteria['category'] ?? 'https://schema.org/Product';
        $agents = $this->discovery->findAgents($category);

        $results = [];
        foreach ($agents as $agentResult) {
            // 2. Handshake (Simplified for v0.1 - assuming direct trust or skip for now)
            // In full flow: $this->session->createConnectionRequest(...) -> transport -> handle response

            // 3. Commerce Negotiation
            $txId = uniqid('tx_');
            $transaction = new CommerceTransaction($txId);

            try {
                $negotiateRequest = $transaction->createNegotiation($criteria);

                // 4. Transport
                // We need to serialize the request. In OACP v0.1 we just send JSON.
                $payload = json_encode($negotiateRequest->toArray());

                $response = $this->transport->send($agentResult->did, $payload);

                if ($response->isSuccess()) {
                    $offerData = json_decode($response->getBody(), true);
                    $results[] = [
                        'did' => $agentResult->did,
                        'offer' => $offerData
                    ];

                    // 5. Persist State
                    $this->repository->save($txId, [
                        'did' => $agentResult->did,
                        'state' => $transaction->getCurrentState(),
                        'offer' => $offerData
                    ]);
                }
            } catch (\Exception $e) {
                // Log error
                error_log("Failed to negotiate with {$agentResult->did}: " . $e->getMessage());
            }
        }

        return $results;
    }
}
