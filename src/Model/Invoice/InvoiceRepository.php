<?php

namespace Thales\EmissorNF\Model\Invoice;

use PDO;
use Thales\EmissorNF\Config\Database\Database;
use Exception;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getAll(): array
    {
        $sql = "SELECT i.*, c.name AS client_name
                FROM invoice i
                JOIN client c ON c.id = i.client_id
                ORDER BY i.created_at DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT i.*, c.name AS client_name
                  FROM invoice i
                  JOIN client c ON c.id = i.client_id
                 WHERE i.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$invoice) {
            return null;
        }

        $stmtItems = $this->conn->prepare("
            SELECT ii.*, p.name AS product_name
            FROM invoice_item ii
            JOIN product p ON p.id = ii.product_id
            WHERE ii.invoice_id = :id
        ");
        $stmtItems->execute(['id' => $id]);

        $invoice['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $invoice;
    }

    public function create(array $invoiceData, array $items): bool
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("
                INSERT INTO invoice (client_id, number, notes, total)
                VALUES (:client_id, :number, :notes, 0)
            ");
            $stmt->execute([
                'client_id' => $invoiceData['client_id'],
                'number'    => $invoiceData['number'],
                'notes'     => $invoiceData['notes'] ?? null,
            ]);

            $invoiceId = $this->conn->lastInsertId();
            $total = 0;

            $stmtItem = $this->conn->prepare("
                INSERT INTO invoice_item (invoice_id, product_id, quantity, unit_price)
                VALUES (:invoice_id, :product_id, :quantity, :unit_price)
            ");

            foreach ($items as $item) {
                $stmtPrice = $this->conn->prepare("SELECT price FROM product WHERE id = :id");
                $stmtPrice->execute(['id' => $item['product_id']]);
                $product = $stmtPrice->fetch(PDO::FETCH_ASSOC);

                if (!$product) {
                    throw new Exception("Produto não encontrado");
                }

                $unitPrice = (float)$product['price'];
                $quantity = (int)$item['quantity'];

                $stmtItem->execute([
                    'invoice_id'  => $invoiceId,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $quantity,
                    'unit_price'  => $unitPrice,
                ]);

                $total += $quantity * $unitPrice;
            }

            $update = $this->conn->prepare("UPDATE invoice SET total = :total WHERE id = :id");
            $update->execute([
                'total' => $total,
                'id'    => $invoiceId
            ]);

            return $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    public function getLastInvoice(): ?array
    {
        $stmt = $this->conn->query("SELECT number FROM invoice ORDER BY id DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function delete(int $id): bool
    {
        try {
            $this->conn->beginTransaction();

            $this->conn->prepare("DELETE FROM invoice_item WHERE invoice_id = :id")
                ->execute(['id' => $id]);

            $this->conn->prepare("DELETE FROM invoice WHERE id = :id")
                ->execute(['id' => $id]);

            return $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
