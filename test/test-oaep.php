<?php

require_once __DIR__ . '/../packages/oaep/src/Identity/DIDDocument.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolverInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolver.php';
require_once __DIR__ . '/../packages/oaep/src/Security/KeyProviderInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Security/SoftwareKeyProvider.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerificationResult.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerifiableCredentialHandlerInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Trust/VerifiableCredentialHandler.php';
require_once __DIR__ . '/../packages/oaep/src/Session/AgentProfile.php';
require_once __DIR__ . '/../packages/oaep/src/Session/OAEPSession.php';

use OAP\Core\Identity\DIDResolver;
use OAP\Core\Security\SoftwareKeyProvider;
use OAP\Core\Trust\VerifiableCredentialHandler;
use OAP\Core\Session\OAEPSession;
use OAP\Core\Session\AgentProfile;

echo "Starting OAP Core Kernel Verification...\n\n";

// Setup
$didResolver = new DIDResolver();
$keyProvider = new SoftwareKeyProvider();
$vcHandler = new VerifiableCredentialHandler($didResolver);
$session = new OAEPSession($keyProvider, $didResolver);

// Test 1: DID Resolution
echo "Test 1: Resolve 'did:web:shop.example.com'...\n";
$didDoc = $didResolver->resolve("did:web:shop.example.com");
if ($didDoc && $didDoc->getId() === "did:web:shop.example.com") {
    echo "[PASS] Resolved DID Document.\n";
    echo "  - Service Endpoint: " . $didDoc->getServiceEndpoint('OACP') . "\n";
} else {
    echo "[FAIL] Could not resolve DID.\n";
}
echo "\n";

// Test 2: VC Issuance & Verification
echo "Test 2: Issue and Verify VC...\n";
$claims = ['name' => 'Alice', 'role' => 'Buyer'];
$vcJson = $vcHandler->issue($claims, $keyProvider);
echo "  - Issued VC: " . substr($vcJson, 0, 50) . "...\n";

// Verify (Mocking the issuer DID resolution to match what we expect)
// In our mock resolver, 'did:web:shop.example.com' returns a key.
// Let's pretend our issuer is that shop for verification test.
// But wait, the issue() method used 'did:key:mock-issuer'.
// Our mock resolver handles did:key.
$verification = $vcHandler->verify($vcJson, 'did:key:mock-issuer');

if ($verification->isValid) {
    echo "[PASS] VC Verified.\n";
} else {
    echo "[FAIL] VC Verification failed: " . implode(', ', $verification->errors) . "\n";
}
echo "\n";

// Test 3: Session Handshake
echo "Test 3: Create Connection Request...\n";
$profile = new AgentProfile("did:key:alice");
$request = $session->createConnectionRequest($profile);
echo "  - Request: " . substr($request, 0, 50) . "...\n";

try {
    $challenge = $session->handleConnectionRequest($request);
    echo "[PASS] Handshake Challenge generated.\n";
} catch (Exception $e) {
    echo "[FAIL] Handshake failed: " . $e->getMessage() . "\n";
}

echo "\nDone.\n";
