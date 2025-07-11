<?php

namespace Thales\EmissorNF\Controller;

use Thales\EmissorNF\Service\InvoiceService;
use Thales\EmissorNF\resources\Response;
use Thales\EmissorNF\resources\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController
{
    private InvoiceService $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function index(): void
    {
        $invoices = $this->service->getAll();
        Response::sendJson($invoices, 200);
    }

    public function createForm(): void
    {
        View::render('invoices.index');
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['client_id']) || empty($data['items'])) {
            Response::sendError($data, 422);
        }

        $invoiceData = [
            'client_id' => $data['client_id'],
            'number'    => $this->service->generateInvoiceNumber(),
            'total'     => $data['total'] ?? 0,
            'notes'     => $data['notes'] ?? null,
        ];

        $items = $data['items'];

        if (!is_array($items) || count($items) === 0) {
            Response::sendError('Itens da nota fiscal inválidos.', 422);
        }

        $created = $this->service->create($invoiceData, $items);

        if ($created) {
            header('Location: /invoices/index');
            exit;
        }

        Response::sendError('Erro ao criar nota fiscal.', 500);
    }

    public function show($id): void
    {
        $invoice = $this->service->getById((int)$id);

        if (!$invoice) {
            Response::sendError('Nota fiscal não encontrada.', 404);
        }

        Response::sendJson($invoice);
    }

    public function list(): void
    {
        View::render('invoices.list');
    }


    public function delete($id): void
    {
        if ($this->service->delete((int)$id)) {
            header('Location: /invoices');
            exit;
        }

        Response::sendError('Erro ao deletar nota fiscal.', 500);
    }

    public function generatePdf(int $id): void
    {
        $invoice = $this->service->getById($id);

        if (!$invoice) {
            Response::sendError('Nota fiscal não encontrada.', 404);
        }

        ob_start();
        include __DIR__ . '/../View/invoices/pdfTemplate.php';
        $html = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("nota_fiscal_{$invoice['number']}.pdf", ['Attachment' => true]);
    }
}
