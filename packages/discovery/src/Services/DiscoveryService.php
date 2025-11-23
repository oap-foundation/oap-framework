<?php

namespace OAP\Discovery\Services;

use OAP\Discovery\Interfaces\DiscoveryAdapterInterface;
use OAP\Discovery\Models\AgentAnnouncement;
use OAP\Discovery\Exceptions\InvalidVocabularyException;

class DiscoveryService
{
    private DiscoveryAdapterInterface $adapter;

    public function __construct(DiscoveryAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @throws InvalidVocabularyException
     */
    public function findAgents(string $capability): array
    {
        $this->validateCapability($capability);
        return $this->adapter->findByCapability($capability);
    }

    /**
     * @throws InvalidVocabularyException
     */
    public function announcePresence(AgentAnnouncement $announcement): bool
    {
        foreach ($announcement->capabilities as $capability) {
            $this->validateCapability($capability);
        }
        return $this->adapter->announce($announcement);
    }

    /**
     * @throws InvalidVocabularyException
     */
    private function validateCapability(string $capability): void
    {
        // Allow https://schema.org/* or unspsc:*
        $schemaOrgPattern = '/^https:\/\/schema\.org\/[a-zA-Z0-9]+$/';
        $unspscPattern = '/^unspsc:[0-9]+$/';

        if (!preg_match($schemaOrgPattern, $capability) && !preg_match($unspscPattern, $capability)) {
            throw new InvalidVocabularyException("Capability '$capability' does not match allowed vocabulary (Schema.org or UNSPSC).");
        }
    }
}
