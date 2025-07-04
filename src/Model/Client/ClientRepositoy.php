<?php

namespace Thales\EmissorNF\Model\Client;

use PDO;
use Thales\EmissorNF\config\Database\Database;

class ClientRepository
{
    public function findAll(): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO clients (name, cpf_cnpj, email, address, phone) VALUES (:name, :cpf_cnpj, :email, :address, :phone)");
        return $stmt->execute([
            ':name' => $data['name'],
            ':cpf_cnpj' => $data['cpf_cnpj'],
            ':email' => $data['email'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
        ]);
    }
}
