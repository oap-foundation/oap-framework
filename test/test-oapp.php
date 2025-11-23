<?php

// Include dependencies manually
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDDocument.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolverInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Identity/DIDResolver.php';
require_once __DIR__ . '/../packages/oaep/src/Security/KeyProviderInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Security/SoftwareKeyProvider.php';

require_once __DIR__ . '/../packages/oapp/src/Model/Money.php';
require_once __DIR__ . '/../packages/oapp/src/Model/PaymentRequest.php';
require_once __DIR__ . '/../packages/oapp/src/Model/PaymentAuthorization.php';
require_once __DIR__ . '/../packages/oapp/src/Model/PaymentConfirmation.php';
require_once __DIR__ . '/../packages/oapp/src/Exception/PaymentException.php';
require_once __DIR__ . '/../packages/oapp/src/Exception/PaymentFailedException.php';
require_once __DIR__ . '/../packages/oapp/src/Exception/InvalidSignatureException.php';
require_once __DIR__ . '/../packages/oapp/src/Gateway/PaymentGatewayInterface.php';
require_once __DIR__ . '/../packages/oapp/src/Gateway/MockGatewayAdapter.php';
require_once __DIR__ . '/../packages/oapp/src/Manager/PaymentManager.php';

use OAP\Payment\Model\Money;
use OAP\Payment\Gateway\MockGatewayAdapter;
use OAP\Payment\Manager\PaymentManager;
use OAP\Core\Security\SoftwareKeyProvider;
use OAP\Core\Identity\DIDResolver;

echo "Starting OAPP Payment Protocol Verification...\n\n";

// 1. Setup
$gateway = new MockGatewayAdapter();
$keyProvider = new SoftwareKeyProvider(); // Generates random keys
$didResolver = new DIDResolver();
$manager = new PaymentManager($gateway, $keyProvider, $didResolver);

// 2. Test Money
echo "Test 1: Money Value Object...\n";
try {
    $m = new Money(1299, 'EUR');
    if ($m->getAmount() === 1299 && $m->getCurrency() === 'EUR') {
        echo "[PASS] Money created correctly.\n";
    } else {
        echo "[FAIL] Money values incorrect.\n";
    }
} catch (Exception $e) {
    echo "[FAIL] Money creation failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 3. Test Full Flow
echo "Test 2: Full Payment Flow (Request -> Auth -> Execute)...\n";
try {
    // A. Create Request
    $orderId = "urn:uuid:" . uniqid();
    $amount = new Money(5000, 'EUR'); // 50.00 EUR
    $request = $manager->createRequest($orderId, $amount, "IBAN123456");

    echo "  [INFO] Request created for Order: $orderId\n";

    // B. Authorize
    $auth = $manager->authorize($request, ['token' => 'tok_test_123']);
    echo "  [INFO] Authorization signed.\n";

    // C. Execute
    $confirmation = $manager->execute($auth);

    if ($confirmation->getStatus() === 'SUCCESS') {
        echo "[PASS] Payment executed successfully. TxID: " . $confirmation->getTransactionId() . "\n";
    } else {
        echo "[FAIL] Payment status: " . $confirmation->getStatus() . "\n";
    }

} catch (Exception $e) {
    echo "[FAIL] Flow failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 4. Test Failure Case
echo "Test 3: Payment Failure (Zero Amount)...\n";
try {
    $amount = new Money(0, 'EUR');
    $request = $manager->createRequest("urn:uuid:fail", $amount, "addr");
    $auth = $manager->authorize($request, []);
    $manager->execute($auth);
    echo "[FAIL] Should have thrown PaymentFailedException.\n";
} catch (\OAP\Payment\Exception\PaymentFailedException $e) {
    echo "[PASS] Caught expected PaymentFailedException: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "[FAIL] Caught unexpected exception: " . get_class($e) . "\n";
}

echo "\nDone.\n";
