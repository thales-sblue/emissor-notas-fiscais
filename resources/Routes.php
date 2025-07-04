<?php

use Thales\EmissorNF\Controller\ClientController;
use Thales\EmissorNF\Model\Client\ClientRepository;
use Thales\EmissorNF\Service\ClientService;

$clientService = new ClientService(new ClientRepository());
$clientController = new ClientController($clientService);

return [
    ['GET',  '/clients',              [$clientController, 'createForm']],
    ['GET',  '/clients/index',        [$clientController, 'index']],
    ['POST', '/clients',              [$clientController, 'create']],
    ['GET',  '/clients/{id}',         [$clientController, 'show']],
    ['POST', '/clients/{id}/delete',  [$clientController, 'delete']],
];
