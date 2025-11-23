<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Assuming composer install ran
// Fallback for dev environment without vendor/autoload
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    // Manually require the local libs if vendor missing (for verification script context)
    // In a real scenario, user runs composer install.
    // We will rely on the verification script to handle includes if needed, 
    // but for this file to be "correct", it expects autoload.
}

use OAP\Kernel\Kernel;
use OAP\Kernel\Service\Brain;

// 1. Initialize Kernel
// We assume .env exists or defaults are used
$kernel = new Kernel();

// 2. Get Brain
$brain = $kernel->getService(Brain::class);

echo "Buyer Agent Started.\n";
echo "Searching for Laptops...\n";

// 3. Execute Flow
$results = $brain->findAndNegotiate([
    'category' => 'https://schema.org/ElectronicsStore', // Discovery looks for Agent Capability
    'criteria' => [
        'product' => 'Laptop',
        'max_price' => 1500
    ]
]);

// 4. Output
echo "Found " . count($results) . " offer(s):\n";
foreach ($results as $result) {
    echo "------------------------------------------------\n";
    echo "Seller: " . $result['did'] . "\n";
    echo "Offer: " . json_encode($result['offer'], JSON_PRETTY_PRINT) . "\n";
}
