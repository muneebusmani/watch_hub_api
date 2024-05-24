<?php
namespace models;

use PDO;

class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $conn)
    {
        $this->conn = $conn;
    }

    public function getAll(): array
    {
        $sql  = 'SELECT * FROM product_tb';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['is_available'] = (bool) $row['is_available'];
            $data[]              = $row;
        }
        return $data;
    }

    public function create(array $data): string
    {
        $sql  = 'INSERT INTO product_tb (name, size, is_available) VALUES (:name, :size, :is_available)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':size', $data['size'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':is_available', (bool) ($data['is_available'] ?? false), PDO::PARAM_BOOL);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function get(string $id): array|false
    {
        $sql  = 'SELECT * FROM product_tb WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data != false) {
            $data['is_available'] = (bool) $data['is_available'];
        }
        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql  = 'UPDATE product_tb SET name = :name, size = :size, is_available = :is_available WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $new['name'] ?? $current['name'], PDO::PARAM_STR);
        $stmt->bindValue(':size', $new['size'] ?? $current['size'], PDO::PARAM_INT);
        $stmt->bindValue(':is_available', $new['is_available'] ?? $current['is_available'], PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $current['id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {
        $sql  = 'DELETE FROM product_tb WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
