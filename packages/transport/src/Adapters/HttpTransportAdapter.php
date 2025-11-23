<?php

namespace OAP\Transport\Adapters;

use OAP\Transport\TransportResponse;
use OAP\Transport\Exceptions\UnreachableAgentException;
use OAP\Transport\Exceptions\AgentProtocolException;

class HttpTransportAdapter implements TransportAdapterInterface
{
    private int $timeout;

    public function __construct(int $timeout = 10)
    {
        $this->timeout = $timeout;
    }

    public function supports(string $serviceEndpointUrl): bool
    {
        return strpos($serviceEndpointUrl, 'http://') === 0 || strpos($serviceEndpointUrl, 'https://') === 0;
    }

    public function dispatch(string $url, string $payload): TransportResponse
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/oap+json',
            'Content-Length: ' . strlen($payload)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        $responseBody = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($errno) {
            throw new UnreachableAgentException("Network error: $error (Code: $errno)");
        }

        // Treat 404, 500 etc as valid protocol responses (but maybe failure status)
        // However, if the server is down (connect failure), it's UnreachableAgentException (handled by errno above)

        // If we get a 404 or 500, it's technically a protocol exception if we expect OAP compliance,
        // but for now we wrap it in TransportResponse and let the manager decide, OR throw AgentProtocolException
        // The briefing says: "AgentProtocolException (Gegenseite antwortet mit 400/500 oder Müll)"

        if ($statusCode >= 400) {
            throw new AgentProtocolException("Agent responded with error status: $statusCode. Body: $responseBody");
        }

        return new TransportResponse($statusCode, $responseBody);
    }
}
