<?php

namespace Thales\EmissorNF\Controller;

use Thales\EmissorNF\Service\ProductService;
use Thales\EmissorNF\resources\View;
use Thales\EmissorNF\resources\Response;

class ProductController
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(): void
    {
        $products = $this->service->getAll();
        Response::sendJson($products, 200);
    }

    public function createForm(): void
    {
        View::render('products.index');
    }

    public function create(): void
    {
        $data = $_POST;

        if (empty($data['name']) || empty($data['price'])) {
            Response::sendError('Nome e preço são obrigatórios', 422);
        }

        $created = $this->service->create($data);

        if ($created) {
            header('Location: /products/index');
            exit;
        }

        Response::sendError('Erro ao cadastrar produto', 500);
    }

    public function show($id): void
    {
        $product = $this->service->getById((int)$id);

        if (!$product) {
            Response::sendError('Produto não encontrado', 404);
        }

        Response::sendJson($product);
    }

    public function delete($id): void
    {
        if ($this->service->delete((int)$id)) {
            header('Location: /products');
            exit;
        }

        Response::sendError('Erro ao deletar produto', 500);
    }
}
