<?php

// Manually include all dependencies since we might not have vendor/autoload
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDDocument.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolverInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolver.php';
require_once __DIR__ . '/../packages/oaep/src/Security/KeyProviderInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Security/SoftwareKeyProvider.php';
require_once __DIR__ . '/../packages/oaep/src/Session/AgentProfile.php';
require_once __DIR__ . '/../packages/oaep/src/Session/OAEPSession.php';

require_once __DIR__ . '/../packages/oacp/src/Messages/NegotiateRequest.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OfferResponse.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OrderRequest.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OrderConfirmation.php';
require_once __DIR__ . '/../packages/oacp/src/Validation/SchemaValidator.php';
require_once __DIR__ . '/../packages/oacp/src/Transaction/TransactionState.php';
require_once __DIR__ . '/../packages/oacp/src/Transaction/CommerceTransaction.php';

require_once __DIR__ . '/../packages/discovery/src/Models/AgentAnnouncement.php';
require_once __DIR__ . '/../packages/discovery/src/Models/TrustMetadata.php';
require_once __DIR__ . '/../packages/discovery/src/Models/DiscoveryResult.php';
require_once __DIR__ . '/../packages/discovery/src/Interfaces/DiscoveryAdapterInterface.php';
require_once __DIR__ . '/../packages/discovery/src/Exceptions/InvalidVocabularyException.php';
require_once __DIR__ . '/../packages/discovery/src/Services/DiscoveryService.php';
require_once __DIR__ . '/../packages/discovery/src/Adapters/WebCrawlerAdapter.php';

require_once __DIR__ . '/../packages/transport/src/Exceptions/OAPTransportException.php';
require_once __DIR__ . '/../packages/transport/src/Exceptions/ResolutionException.php';
require_once __DIR__ . '/../packages/transport/src/Exceptions/UnreachableAgentException.php';
require_once __DIR__ . '/../packages/transport/src/Exceptions/AgentProtocolException.php';
require_once __DIR__ . '/../packages/transport/src/TransportResponse.php';
require_once __DIR__ . '/../packages/transport/src/Adapters/TransportAdapterInterface.php';
require_once __DIR__ . '/../packages/transport/src/Adapters/HttpTransportAdapter.php';
require_once __DIR__ . '/../packages/transport/src/TransportFactory.php';
require_once __DIR__ . '/../packages/transport/src/TransportManager.php';

require_once __DIR__ . '/../skeleton/src/Repository/TransactionRepositoryInterface.php';
require_once __DIR__ . '/../skeleton/src/Repository/SqliteTransactionRepository.php';
require_once __DIR__ . '/../skeleton/src/Service/Brain.php';
require_once __DIR__ . '/../skeleton/src/Controller/HttpListener.php';

// Mock Kernel if dependencies missing
if (!class_exists('DI\ContainerBuilder')) {
    echo "DI Container missing, using Manual Wiring for Verification...\n";
}

use OAP\Kernel\Repository\SqliteTransactionRepository;
use OAP\Kernel\Service\Brain;
use OAP\Kernel\Controller\HttpListener;
use OAP\Discovery\Adapters\WebCrawlerAdapter;
use OAP\Core\Session\OAEPSession;
use OAP\Transport\TransportManager;
use OAP\Transport\TransportFactory;
use OAP\Core\Identity\DIDResolver;
use OAP\Core\Security\SoftwareKeyProvider;

echo "Starting Agent Kernel Verification...\n\n";

// 1. Setup Dependencies Manually
$didResolver = new DIDResolver();
$keyProvider = new SoftwareKeyProvider();
$discoveryAdapter = new WebCrawlerAdapter();

// Subclass Factory to avoid default adapters
class CleanTransportFactory extends TransportFactory
{
    public function __construct()
    {
        // Do not register default adapters
    }
}
$transportFactory = new CleanTransportFactory();

$transportManager = new TransportManager($didResolver, $transportFactory);
$session = new OAEPSession($keyProvider, $didResolver);
$repository = new SqliteTransactionRepository();

// 2. Initialize Brain
$brain = new Brain(
    $discoveryAdapter,
    $session,
    $transportManager,
    $repository,
    $keyProvider,
    $didResolver
);

// 3. Test Brain Flow (Buyer)
echo "Test 1: Brain Negotiation Flow...\n";

// We need to mock the transport adapter to return a valid OfferResponse JSON
// The WebCrawlerAdapter returns 'did:web:shop.example.com' for ElectronicsStore.
// The TransportManager will try to resolve 'did:web:shop.example.com' -> 'https://shop.example.com/api/agent/v1'
// Then HttpTransportAdapter will try to curl that. We need to intercept this.

// Let's register a Mock Adapter in the factory
class MockKernelAdapter implements \OAP\Transport\Adapters\TransportAdapterInterface
{
    public function supports(string $url): bool
    {
        return true;
    } // Catch all
    public function dispatch(string $url, string $payload): \OAP\Transport\TransportResponse
    {
        // Return a valid OfferResponse JSON
        $offer = [
            '@type' => 'OfferResponse',
            'product' => ['name' => 'Mock Laptop'],
            'price' => ['amount' => 999, 'currency' => 'EUR'],
            'validUntil' => date('c'),
            'credentials' => []
        ];
        return new \OAP\Transport\TransportResponse(200, json_encode($offer));
    }
}
$transportFactory->registerAdapter(new MockKernelAdapter());

$results = $brain->findAndNegotiate([
    'category' => 'https://schema.org/ElectronicsStore',
    'criteria' => ['product' => 'Laptop']
]);

if (count($results) > 0) {
    echo "[PASS] Brain found " . count($results) . " offer(s).\n";
    echo "  - Offer: " . $results[0]['offer']['product']['name'] . "\n";
} else {
    echo "[FAIL] Brain found no offers.\n";
}
echo "\n";

// 4. Test Repository Persistence
echo "Test 2: Repository Persistence...\n";
$allTx = $repository->getAll();
if (count($allTx) > 0) {
    echo "[PASS] Repository saved " . count($allTx) . " transaction(s).\n";
    echo "  - Last State: " . $allTx[0]['state'] . "\n";
} else {
    echo "[FAIL] Repository is empty.\n";
}
echo "\n";

// 5. Test HttpListener (Seller)
echo "Test 3: HttpListener (Seller)...\n";
$listener = new HttpListener();
$negotiatePayload = json_encode([
    '@type' => 'NegotiateRequest',
    'criteria' => ['term' => 'Laptop'],
    'budget' => [],
    'category' => 'https://schema.org/Product'
]);

$responseJson = $listener->handleRequest($negotiatePayload);
$response = json_decode($responseJson, true);

if ($response && isset($response['@type']) && $response['@type'] === 'OfferResponse') {
    echo "[PASS] Listener returned OfferResponse.\n";
} else {
    echo "[FAIL] Listener returned invalid response: $responseJson\n";
}

echo "\nDone.\n";
