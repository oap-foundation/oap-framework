<?php

namespace OAP\Discovery\Adapters;

use OAP\Discovery\Interfaces\DiscoveryAdapterInterface;
use OAP\Discovery\Models\AgentAnnouncement;
use OAP\Discovery\Models\DiscoveryResult;
use OAP\Discovery\Models\TrustMetadata;

class WebCrawlerAdapter implements DiscoveryAdapterInterface
{
    // Simulating an in-memory index for this v0.1 implementation
    private array $index = [];

    public function __construct()
    {
        // Pre-populate with some dummy data for testing
        $this->index[] = new AgentAnnouncement(
            "did:web:shop.example.com",
            ["https://schema.org/ElectronicsStore"],
            ["oacp" => "https://shop.example.com/api/agent/v1"],
            "dummy_proof"
        );
    }

    public function findByCapability(string $schemaTerm): array
    {
        $results = [];
        foreach ($this->index as $announcement) {
            if (in_array($schemaTerm, $announcement->capabilities)) {
                // In a real implementation, we would fetch the DID document and verify credentials here.
                // For v0.1, we mock the trust metadata.
                $trust = new TrustMetadata(true, ["did:web:handelskammer.at"], "2025-12-31");

                $results[] = new DiscoveryResult(
                    $announcement->did,
                    $announcement->serviceEndpoints['oacp'] ?? '',
                    $announcement->capabilities,
                    $trust
                );
            }
        }
        return $results;
    }

    public function announce(AgentAnnouncement $announcement): bool
    {
        $this->index[] = $announcement;
        return true;
    }
}
