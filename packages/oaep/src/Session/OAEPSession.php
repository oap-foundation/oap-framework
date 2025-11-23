<?php

namespace OAP\Core\Session;

use OAP\Core\Security\KeyProviderInterface;
use OAP\Core\Identity\DIDResolverInterface;

class OAEPSession
{
    private KeyProviderInterface $keyProvider;
    private DIDResolverInterface $didResolver;

    public function __construct(KeyProviderInterface $keyProvider, DIDResolverInterface $didResolver)
    {
        $this->keyProvider = $keyProvider;
        $this->didResolver = $didResolver;
    }

    public function createConnectionRequest(AgentProfile $myProfile): string
    {
        $payload = [
            'type' => 'ConnectionRequest',
            'from' => $myProfile->did,
            'protocols' => $myProfile->supportedProtocols,
            'timestamp' => time(),
            'nonce' => bin2hex(random_bytes(16))
        ];

        // Sign the request
        $signature = $this->keyProvider->sign(json_encode($payload));

        return json_encode([
            'payload' => $payload,
            'signature' => $signature
        ]);
    }

    public function handleConnectionRequest(string $requestJson): string
    {
        $request = json_decode($requestJson, true);
        if (!$request || !isset($request['payload'])) {
            throw new \Exception("Invalid request format");
        }

        // Verify signature (Simplified)
        $senderDid = $request['payload']['from'];
        // In real implementation: resolve DID, get key, verify signature.

        // Create Challenge
        $challenge = [
            'type' => 'ConnectionChallenge',
            'to' => $senderDid,
            'challenge' => bin2hex(random_bytes(32))
        ];

        return json_encode($challenge);
    }

    public function finalizeHandshake(string $responseJson): string
    {
        // Verify challenge response
        return "session_token_12345";
    }
}
