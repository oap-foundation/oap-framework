<?php

namespace OAP\Kernel\Controller;

use OAP\Commerce\Transaction\CommerceTransaction;
use OAP\Commerce\Messages\NegotiateRequest;

class HttpListener
{
    public function handleRequest(string $payload): string
    {
        // 1. Parse Payload (Simplified - assumes cleartext JSON for v0.1 demo)
        // In real OAP, this would be encrypted OAE packet.
        $data = json_decode($payload, true);

        if (!$data || !isset($data['@type'])) {
            return json_encode(['error' => 'Invalid payload']);
        }

        // 2. Route based on Type
        if ($data['@type'] === 'NegotiateRequest') {
            return $this->handleNegotiation($data);
        }

        return json_encode(['error' => 'Unknown message type']);
    }

    private function handleNegotiation(array $data): string
    {
        // Simulate Seller Logic
        // 1. Create Transaction
        $tx = new CommerceTransaction(uniqid('tx_seller_'));

        // 2. Reconstruct Request Object (Validation)
        // This also advances the state to NEGOTIATING
        $request = $tx->createNegotiation($data['criteria']);

        // 3. Create Offer (Mock Logic)
        $productData = [
            'name' => 'Refurbished MacBook Pro 2021',
            'description' => 'Excellent condition',
            'sku' => 'MBP-2021-REF'
        ];

        $offer = $tx->createOffer($request, $productData);

        return json_encode($offer->toArray());
    }
}
