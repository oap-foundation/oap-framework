<?php

require_once __DIR__ . '/../packages/oaep/src/Identity/DIDDocument.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolverInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolver.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerificationResult.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerifiableCredentialHandlerInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerifiableCredentialHandler.php';

require_once __DIR__ . '/../packages/discovery/src/Models/AgentAnnouncement.php';
require_once __DIR__ . '/../packages/discovery/src/Models/TrustMetadata.php';
require_once __DIR__ . '/../packages/discovery/src/Models/DiscoveryResult.php';
require_once __DIR__ . '/../packages/discovery/src/Interfaces/DiscoveryAdapterInterface.php';
require_once __DIR__ . '/../packages/discovery/src/Exceptions/InvalidVocabularyException.php';
require_once __DIR__ . '/../packages/discovery/src/Services/DiscoveryService.php';
require_once __DIR__ . '/../packages/discovery/src/Adapters/WebCrawlerAdapter.php';

use OAP\Discovery\Services\DiscoveryService;
use OAP\Discovery\Adapters\WebCrawlerAdapter;
use OAP\Discovery\Models\AgentAnnouncement;
use OAP\Discovery\Exceptions\InvalidVocabularyException;

echo "Starting OAP Discovery Module Verification...\n\n";

$adapter = new WebCrawlerAdapter();
$service = new DiscoveryService($adapter);

// Test 1: Search for existing agent (ElectronicsStore)
echo "Test 1: Search for 'https://schema.org/ElectronicsStore'...\n";
try {
    $results = $service->findAgents("https://schema.org/ElectronicsStore");
    if (count($results) > 0) {
        echo "[PASS] Found " . count($results) . " agent(s).\n";
        foreach ($results as $result) {
            echo "  - DID: " . $result->did . "\n";
            echo "  - Trust: Verified=" . ($result->trust->hasVerifiedCredential ? 'Yes' : 'No') . "\n";
        }
    } else {
        echo "[FAIL] No agents found.\n";
    }
} catch (Exception $e) {
    echo "[FAIL] Exception: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Announce new agent with valid capability
echo "Test 2: Announce new agent 'did:web:pharmacy.example.com' with 'https://schema.org/Pharmacy'...\n";
$announcement = new AgentAnnouncement(
    "did:web:pharmacy.example.com",
    ["https://schema.org/Pharmacy"],
    ["oacp" => "https://pharmacy.example.com/api"],
    "proof_sig"
);

try {
    $success = $service->announcePresence($announcement);
    if ($success) {
        echo "[PASS] Announcement successful.\n";
        // Verify by searching
        $results = $service->findAgents("https://schema.org/Pharmacy");
        if (count($results) === 1 && $results[0]->did === "did:web:pharmacy.example.com") {
            echo "[PASS] Verification search successful.\n";
        } else {
            echo "[FAIL] Verification search failed.\n";
        }
    } else {
        echo "[FAIL] Announcement returned false.\n";
    }
} catch (Exception $e) {
    echo "[FAIL] Exception: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Invalid Vocabulary (Free text)
echo "Test 3: Search with invalid term 'Billiger Laptop'...\n";
try {
    $service->findAgents("Billiger Laptop");
    echo "[FAIL] Should have thrown InvalidVocabularyException.\n";
} catch (InvalidVocabularyException $e) {
    echo "[PASS] Caught expected exception: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "[FAIL] Caught unexpected exception: " . get_class($e) . "\n";
}

echo "\n";

// Test 4: Invalid Vocabulary (Announcement)
echo "Test 4: Announce with invalid term 'coole schuhe'...\n";
$badAnnouncement = new AgentAnnouncement(
    "did:web:bad.example.com",
    ["coole schuhe"],
    [],
    "proof"
);
try {
    $service->announcePresence($badAnnouncement);
    echo "[FAIL] Should have thrown InvalidVocabularyException.\n";
} catch (InvalidVocabularyException $e) {
    echo "[PASS] Caught expected exception: " . $e->getMessage() . "\n";
}

echo "\nDone.\n";
