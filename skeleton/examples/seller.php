<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OAP\Kernel\Kernel;
use OAP\Kernel\Controller\HttpListener;

$kernel = new Kernel();
$listener = $kernel->getService(HttpListener::class);

// Simulate receiving a POST request
// In a real app: $payload = file_get_contents('php://input');
$payload = $_POST['payload'] ?? file_get_contents('php://input');

if (empty($payload)) {
    // For demo purposes, if run from CLI with no input, show usage
    echo "Seller Agent Running. Send POST request to this script.\n";
    exit(0);
}

$response = $listener->handleRequest($payload);

header('Content-Type: application/json');
echo $response;
