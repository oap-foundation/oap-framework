<?php

namespace OAP\Kernel\Repository;

use PDO;

class SqliteTransactionRepository implements TransactionRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../var/transactions.db';
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->initDb();
    }

    private function initDb(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS transactions (
            id TEXT PRIMARY KEY,
            data TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function save(string $transactionId, array $data): void
    {
        $stmt = $this->pdo->prepare("INSERT OR REPLACE INTO transactions (id, data, updated_at) VALUES (:id, :data, CURRENT_TIMESTAMP)");
        $stmt->execute([
            ':id' => $transactionId,
            ':data' => json_encode($data)
        ]);
    }

    public function get(string $transactionId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT data FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $transactionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? json_decode($row['data'], true) : null;
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM transactions ORDER BY updated_at DESC");
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = json_decode($row['data'], true);
        }
        return $results;
    }
}
