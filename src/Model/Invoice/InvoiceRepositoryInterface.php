<?php

namespace Thales\EmissorNF\Model\Invoice;

interface InvoiceRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?array;
    public function create(array $invoiceData, array $items): bool;
    public function delete(int $id): bool;
}
