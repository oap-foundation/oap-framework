<?php

namespace OAP\Core\Identity;

class DIDResolver implements DIDResolverInterface
{
    public function resolve(string $did): ?DIDDocument
    {
        if (strpos($did, 'did:key:') === 0) {
            return $this->resolveDidKey($did);
        }
        if (strpos($did, 'did:web:') === 0) {
            return $this->resolveDidWeb($did);
        }
        return null;
    }

    private function resolveDidKey(string $did): DIDDocument
    {
        // Mock implementation for did:key
        // In reality, we would decode the multibase string to get the public key.
        // For v1.0, we assume the suffix IS the key for simplicity in this mock.
        $key = substr($did, 8);

        return new DIDDocument($did, [
            [
                'id' => $did . '#key-1',
                'type' => 'Ed25519VerificationKey2020',
                'controller' => $did,
                'publicKeyMultibase' => $key
            ]
        ]);
    }

    private function resolveDidWeb(string $did): ?DIDDocument
    {
        // Mock implementation for did:web
        // In reality, we would fetch https://<domain>/.well-known/did.json

        $domain = str_replace(':', '/', substr($did, 8));
        // Simulate fetching
        if ($domain === 'shop.example.com') {
            return new DIDDocument($did, [
                [
                    'id' => $did . '#owner',
                    'type' => 'Ed25519VerificationKey2020',
                    'controller' => $did,
                    'publicKeyMultibase' => 'z6MkhaXgBZDvotDkL5257faiztiGiC2QtKLGpbnnEGta2doK' // Dummy key
                ]
            ], [
                [
                    'id' => $did . '#oacp',
                    'type' => 'OACP',
                    'serviceEndpoint' => 'https://shop.example.com/api/agent/v1'
                ]
            ]);
        }

        return null;
    }
}
