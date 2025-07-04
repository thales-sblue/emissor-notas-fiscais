<?php

namespace Thales\EmissorNF\Service;

use Thales\EmissorNF\Model\Invoice\InvoiceRepositoryInterface;

class InvoiceService
{
    private InvoiceRepositoryInterface $repository;

    public function __construct(InvoiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): ?array
    {
        return $this->repository->getById($id);
    }

    public function create(array $invoiceData, array $items): bool
    {
        return $this->repository->create($invoiceData, $items);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function generateInvoiceNumber(): string
    {
        $lastInvoice = $this->repository->getLastInvoice() ?? [];

        return isset($lastInvoice['number']) ? ((int)$lastInvoice['number'] + 1) : 1;
    }
}
