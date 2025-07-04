<?php

/** @var array $invoice */
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Nota Fiscal #<?= $invoice['number'] ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h1>Nota Fiscal #<?= $invoice['number'] ?></h1>

    <p><strong>Cliente:</strong> <?= $invoice['client_id'] ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($invoice['created_at'])) ?></p>
    <p><strong>Observações:</strong> <?= $invoice['notes'] ?? 'N/A' ?></p>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Valor Unit.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoice['items'] as $item) : ?>
                <tr>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>R$ <?= number_format($item['unit_price'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($item['quantity'] * $item['unit_price'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="text-align: right; margin-top: 20px;">
        <strong>Total: R$ <?= number_format($invoice['total'], 2, ',', '.') ?></strong>
    </p>
</body>

</html>
