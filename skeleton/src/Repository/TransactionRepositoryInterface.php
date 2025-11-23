<?php

namespace OAP\Kernel\Repository;

interface TransactionRepositoryInterface
{
    public function save(string $transactionId, array $data): void;
    public function get(string $transactionId): ?array;
    public function getAll(): array;
}
