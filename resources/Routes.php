<?php

use Thales\EmissorNF\Controller\ClientController;
use Thales\EmissorNF\Model\Client\ClientRepository;
use Thales\EmissorNF\Service\ClientService;
use Thales\EmissorNF\Controller\ProductController;
use Thales\EmissorNF\Model\Product\ProductRepository;
use Thales\EmissorNF\Service\ProductService;
use Thales\EmissorNF\Controller\InvoiceController;
use Thales\EmissorNF\Model\Invoice\InvoiceRepository;
use Thales\EmissorNF\Service\InvoiceService;

$clientService = new ClientService(new ClientRepository());
$clientController = new ClientController($clientService);

$productService = new ProductService(new ProductRepository());
$productController = new ProductController($productService);

$invoiceService = new InvoiceService(new InvoiceRepository());
$invoiceController = new InvoiceController($invoiceService);

return [
    ['GET',  '/clients',               [$clientController, 'createForm']],
    ['GET',  '/clients/index',         [$clientController, 'index']],
    ['POST', '/clients',               [$clientController, 'create']],
    ['GET',  '/clients/{id}',          [$clientController, 'show']],
    ['POST', '/clients/{id}/delete',   [$clientController, 'delete']],

    ['GET',  '/products',              [$productController, 'createForm']],
    ['GET',  '/products/index',        [$productController, 'index']],
    ['POST', '/products',              [$productController, 'create']],
    ['GET',  '/products/{id}',         [$productController, 'show']],
    ['POST', '/products/{id}/delete',  [$productController, 'delete']],

    ['GET',  '/invoices',              [$invoiceController, 'createForm']],
    ['GET',  '/invoices/index',        [$invoiceController, 'index']],
    ['GET',  '/invoices/list',         [$invoiceController, 'list']],
    ['POST', '/invoices',              [$invoiceController, 'create']],
    ['GET',  '/invoices/{id}/pdf',     [$invoiceController, 'generatePdf']],
    ['GET',  '/invoices/{id}',         [$invoiceController, 'show']],
    ['POST', '/invoices/{id}/delete',  [$invoiceController, 'delete']],

    ['GET', '/home', function () {
        \Thales\EmissorNF\resources\View::render('home');
    }],
];
