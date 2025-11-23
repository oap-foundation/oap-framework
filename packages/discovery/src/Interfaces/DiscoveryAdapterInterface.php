<?php

namespace OAP\Discovery\Interfaces;

use OAP\Discovery\Models\AgentAnnouncement;
use OAP\Discovery\Models\DiscoveryResult;

interface DiscoveryAdapterInterface
{
    /**
     * Searches for agents based on standardized capabilities.
     *
     * @param string $schemaTerm e.g. "https://schema.org/Restaurant"
     * @return DiscoveryResult[]
     */
    public function findByCapability(string $schemaTerm): array;

    /**
     * Publishes the agent's capability to the network.
     *
     * @param AgentAnnouncement $announcement
     * @return bool
     */
    public function announce(AgentAnnouncement $announcement): bool;
}
