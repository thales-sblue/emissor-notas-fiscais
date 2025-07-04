<?php

namespace Thales\EmissorNF\Model\Client;

use PDO;
use PDOException;
use Thales\EmissorNF\config\Database\Database;

class ClientRepository implements ClientRepositoryInterface
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function createClient(array $data): array|false
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO client (name, cpfcnpj, email, address, phone)
                VALUES (:name, :cpfcnpj, :email, :address, :phone)
            ");
            $stmt->execute([
                ':name'      => $data['name'],
                ':cpfcnpj'  => $data['cpfcnpj'],
                ':email'     => $data['email'] ?? null,
                ':address'   => $data['address'] ?? null,
                ':phone'     => $data['phone'] ?? null,
            ]);

            $id = $this->conn->lastInsertId();
            return $this->getClientById($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getClientById(int $id): array|false
    {
        $stmt = $this->conn->prepare("SELECT * FROM client WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllClients(): array
    {
        $stmt = $this->conn->query("SELECT * FROM client ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateClient(int $id, array $data): array|false
    {
        try {
            $stmt = $this->conn->prepare("
                UPDATE client SET
                    name = :name,
                    cpfcnpj = :cpfcnpj,
                    email = :email,
                    address = :address,
                    phone = :phone
                WHERE id = :id
            ");
            $stmt->execute([
                ':id'        => $id,
                ':name'      => $data['name'],
                ':cpfcnpj'  => $data['cpfcnpj'],
                ':email'     => $data['email'] ?? null,
                ':address'   => $data['address'] ?? null,
                ':phone'     => $data['phone'] ?? null,
            ]);

            return $this->getClientById($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteClient(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM client WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
