<?php

namespace Thales\EmissorNF\Model\Product;

interface ProductRepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?array;

    public function create(array $data): bool;

    public function delete(int $id): bool;
}
