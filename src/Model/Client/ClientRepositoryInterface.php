<?php

namespace Thales\EmissorNF\Model\Client;

interface ClientRepositoryInterface
{
    public function createClient(array $data): array|false;
    public function getClientById(int $id): array|false;
    public function getAllClients(): array;
    public function updateClient(int $id, array $data): array|false;
    public function deleteClient(int $id): bool;
}
