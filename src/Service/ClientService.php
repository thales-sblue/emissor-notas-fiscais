<?php

namespace Thales\EmissorNF\Service;

use Thales\EmissorNF\Model\Client\ClientRepositoryInterface;

class ClientService
{
    private ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): array|false
    {
        return $this->repository->createClient($data);
    }

    public function getAll(): array
    {
        return $this->repository->getAllClients();
    }

    public function getById(int $id): array|false
    {
        return $this->repository->getClientById($id);
    }

    public function update(int $id, array $data): array|false
    {
        return $this->repository->updateClient($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->deleteClient($id);
    }
}
