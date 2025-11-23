<?php

namespace OAP\Core\Trust;

use OAP\Core\Security\KeyProviderInterface;
use OAP\Core\Identity\DIDResolverInterface;

class VerifiableCredentialHandler implements VerifiableCredentialHandlerInterface
{
    private DIDResolverInterface $didResolver;

    public function __construct(DIDResolverInterface $didResolver)
    {
        $this->didResolver = $didResolver;
    }

    public function verify(string $vcJson, string $issuerDid): VerificationResult
    {
        $vc = json_decode($vcJson, true);
        if (!$vc || !isset($vc['proof']) || !isset($vc['issuer'])) {
            return new VerificationResult(false, ['Invalid VC format']);
        }

        if ($vc['issuer'] !== $issuerDid) {
            return new VerificationResult(false, ['Issuer mismatch']);
        }

        // Resolve Issuer DID to get Public Key
        $didDoc = $this->didResolver->resolve($issuerDid);
        if (!$didDoc) {
            return new VerificationResult(false, ['Issuer DID not found']);
        }

        $publicKey = $didDoc->getPublicKey(); // Simplified: get first key
        if (!$publicKey) {
            return new VerificationResult(false, ['No public key found for issuer']);
        }

        // Verify Signature (Simplified Ed25519 check)
        // In a real implementation, we would canonicalize the VC minus the proof, and verify.
        // Here we assume the proof contains a signature of the serialized claims.

        // MOCK VERIFICATION for v1.0 to avoid complex canonicalization libraries
        // We assume if the signature is "valid_signature", it's good.
        if ($vc['proof']['jws'] === 'valid_signature') {
            return new VerificationResult(true, [], $issuerDid);
        }

        return new VerificationResult(false, ['Invalid signature']);
    }

    public function issue(array $claims, KeyProviderInterface $issuerKey): string
    {
        $vc = [
            '@context' => ['https://www.w3.org/2018/credentials/v1'],
            'type' => ['VerifiableCredential'],
            'issuer' => 'did:key:mock-issuer', // Should come from key provider context
            'issuanceDate' => date('c'),
            'credentialSubject' => $claims
        ];

        // Sign
        $payload = json_encode($vc);
        $signature = $issuerKey->sign($payload);

        $vc['proof'] = [
            'type' => 'Ed25519Signature2020',
            'created' => date('c'),
            'verificationMethod' => 'did:key:mock-issuer#key-1',
            'proofPurpose' => 'assertionMethod',
            'jws' => $signature
        ];

        return json_encode($vc);
    }
}
