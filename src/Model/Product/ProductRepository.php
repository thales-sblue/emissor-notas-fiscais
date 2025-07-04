<?php

namespace Thales\EmissorNF\Model\Product;

use PDO;
use PDOException;
use Thales\EmissorNF\config\Database\Database;

class ProductRepository implements ProductRepositoryInterface
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM product ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function create(array $data): bool
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO product (name, description, unit, price)
                VALUES (:name, :description, :unit, :price)
            ");
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':description', $data['description'] ?? null);
            $stmt->bindValue(':unit', $data['unit'] ?? 'un');
            $stmt->bindValue(':price', $data['price']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM product WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
