<?php

namespace Thales\EmissorNF\Controller;

use Thales\EmissorNF\Service\ClientService;
use Thales\EmissorNF\resources\View;
use Thales\EmissorNF\resources\Response;

class ClientController
{
    private ClientService $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index(): void
    {
        $clients = $this->service->getAll();
        Response::sendJson($clients, 200);
    }

    public function createForm(): void
    {
        View::render('clients.index');
    }

    public function create(): void
    {
        $data = $_POST;

        if (empty($data['name']) || empty($data['cpfcnpj'])) {
            Response::sendError('Nome e CPF/CNPJ são obrigatórios', 422);
        }

        $created = $this->service->create($data);

        if ($created) {
            header('Location: /clients/index');
            exit;
        }

        Response::sendError('Erro ao cadastrar cliente', 500);
    }

    public function show($id): void
    {
        $client = $this->service->getById((int)$id);

        if (!$client) {
            Response::sendError('Cliente não encontrado', 404);
        }

        Response::sendJson($client);
    }

    public function delete($id): void
    {
        if ($this->service->delete((int)$id)) {
            header('Location: /clients');
            exit;
        }

        Response::sendError('Erro ao deletar cliente', 500);
    }
}
