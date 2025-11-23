<?php

namespace OAP\Transport;

class TransportResponse
{
    private int $statusCode;
    private string $body;
    private array $metadata;

    public function __construct(int $statusCode, string $body, array $metadata = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->metadata = $metadata;
    }

    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
