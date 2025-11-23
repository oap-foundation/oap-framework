<?php

require_once __DIR__ . '/../packages/oaep/src/Security/KeyProviderInterface.php';
require_once __DIR__ . '/../packages/oaep/src/Security/SoftwareKeyProvider.php';

require_once __DIR__ . '/../packages/oacp/src/Messages/NegotiateRequest.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OfferResponse.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OrderRequest.php';
require_once __DIR__ . '/../packages/oacp/src/Messages/OrderConfirmation.php';
require_once __DIR__ . '/../packages/oacp/src/Validation/SchemaValidator.php';
require_once __DIR__ . '/../packages/oacp/src/Transaction/TransactionState.php';
require_once __DIR__ . '/../packages/oacp/src/Transaction/CommerceTransaction.php';

use OAP\Commerce\Transaction\CommerceTransaction;
use OAP\Commerce\Transaction\TransactionState;
use OAP\Commerce\Validation\SchemaValidator;
use OAP\Core\Security\SoftwareKeyProvider;

echo "Starting OAP Commerce Protocol Verification...\n\n";

$transaction = new CommerceTransaction("tx_123");
$validator = new SchemaValidator();
$keyProvider = new SoftwareKeyProvider();

// Test 1: Negotiation
echo "Test 1: Create Negotiation...\n";
try {
    $negotiation = $transaction->createNegotiation(['term' => 'Laptop']);
    echo "[PASS] Negotiation created. State: " . $transaction->getCurrentState() . "\n";

    if ($validator->validateSchema($negotiation->toArray())) {
        echo "[PASS] Schema Validated.\n";
    } else {
        echo "[FAIL] Schema Validation failed.\n";
    }
} catch (Exception $e) {
    echo "[FAIL] " . $e->getMessage() . "\n";
}
echo "\n";

// Test 2: Offer
echo "Test 2: Receive Offer...\n";
try {
    $productData = ['name' => 'MacBook Pro', 'offers' => ['price' => 999]];
    $offer = $transaction->createOffer($negotiation, $productData);
    echo "[PASS] Offer created. State: " . $transaction->getCurrentState() . "\n";
} catch (Exception $e) {
    echo "[FAIL] " . $e->getMessage() . "\n";
}
echo "\n";

// Test 3: Order & Signing
echo "Test 3: Accept Offer & Sign Order...\n";
try {
    $order = $transaction->acceptOffer($offer, 'user_123');
    echo "[PASS] Order created. State: " . $transaction->getCurrentState() . "\n";

    // Sign
    $order->signByUser($keyProvider);
    $orderArray = $order->toArray();
    if (isset($orderArray['userSignature'])) {
        echo "[PASS] Order signed: " . $orderArray['userSignature'] . "\n";
    } else {
        echo "[FAIL] Order not signed.\n";
    }
} catch (Exception $e) {
    echo "[FAIL] " . $e->getMessage() . "\n";
}
echo "\n";

// Test 4: Invalid Transition
echo "Test 4: Invalid State Transition (Skip to Completed)...\n";
if (!$transaction->canTransitionTo(TransactionState::COMPLETED)) {
    echo "[PASS] Correctly prevented invalid transition to COMPLETED from " . $transaction->getCurrentState() . "\n";
} else {
    echo "[FAIL] Allowed invalid transition.\n";
}

echo "\nDone.\n";
