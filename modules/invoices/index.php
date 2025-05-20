<?php
require_once '../../config/setup.php';
requireAuth();

$page_title = "Facturas - Swift Invoice";
require_once '../../includes/header.php';

$db = new Database();
$conn = $db->connect();

// Consulta SQL (comentar para prueba)
// $stmt = $conn->query("
//     SELECT i.id, i.invoice_number, i.invoice_date, i.created_at,
//            s.total, CONCAT(c.last_name, ' ', c.first_name) AS client_name
//     FROM invoices i
//     JOIN sales s ON i.sale_id = s.id
//     JOIN clients c ON s.client_id = c.id
//     ORDER BY i.invoice_date DESC
// ");
// $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Datos de prueba manual
$invoices = [
    [
        'id' => 1,
        'invoice_number' => 'F001-0001',
        'invoice_date' => '2025-05-01',
        'created_at' => '2025-05-01 10:00:00',
        'total' => 1500.75,
        'client_name' => 'Gómez Pérez Juan'
    ],
    [
        'id' => 2,
        'invoice_number' => 'F001-0002',
        'invoice_date' => '2025-05-03',
        'created_at' => '2025-05-03 11:30:00',
        'total' => 2300.00,
        'client_name' => 'López Martínez Ana'
    ],
    [
        'id' => 3,
        'invoice_number' => 'F001-0003',
        'invoice_date' => '2025-05-05',
        'created_at' => '2025-05-05 09:15:00',
        'total' => 980.50,
        'client_name' => 'Guerra Montes de Oca Annette'
    ],
    [
        'id' => 4,
        'invoice_number' => 'F001-0004',
        'invoice_date' => '2025-05-05',
        'created_at' => '2025-05-05 09:15:00',
        'total' => 980.50,
        'client_name' => 'Sanchez Paz Abelardo'
    ],
    [
        'id' => 5,
        'invoice_number' => 'F001-0005',
        'invoice_date' => '2025-05-05',
        'created_at' => '2025-05-05 09:15:00',
        'total' => 980.50,
        'client_name' => 'Salazar Caballero Antonio'
    ],
    [
        'id' => 6,
        'invoice_number' => 'F001-0006',
        'invoice_date' => '2025-05-05',
        'created_at' => '2025-05-05 09:15:00',
        'total' => 980.50,
        'client_name' => 'Chavez Jara Manuel de Jesus'
    ],
];

?>
<!DOCTYPE html>
<html lang="es">

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Swift Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/swift_invoice/assets/css/tableClients.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
</head>

<nav class="navbar navbar-expand navbar-custom py-2 sticky-top">
        <div class="container-fluid">
        <a class="navbar-brand navbar-brand-custom ms-3" href="/swift_invoice">SWIFT INVOICE</a>
        </div>
    </nav>

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">Pre-Facturas</h2>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (requerido por DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Inicialización de DataTable -->
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#facturasTable')) {
            $('#facturasTable').DataTable({
                dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"B>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>',
                buttons: [
    {
        extend: 'excelHtml5',
        text: '<i class="fa-solid fa-file-excel me-1"></i> Exportar a Excel',
        className: 'btn btn-success'
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa-solid fa-file-pdf me-1"></i> Exportar a PDF',
        className: 'btn btn-danger'
    }
],
                pageLength: 10,
                lengthMenu: [5, 10, 20, 50,100],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        }
    });
</script>

<!-- JSZip (para Excel) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- pdfmake (para PDF) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<body>
    <div class="container mt-5">
    <table id="facturasTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($invoices as $invoice): ?>
<tr>
    <td><?= htmlspecialchars($invoice['id']) ?></td>
    <td><?= htmlspecialchars($invoice['client_name']) ?></td>
    <td><?= htmlspecialchars($invoice['invoice_number']) ?></td>
    <td><?= htmlspecialchars($invoice['invoice_date']) ?></td>
    <td>$<?= number_format($invoice['total'], 2) ?></td>
    <td>
        <a href="generate.php?id=<?= $invoice['id'] ?>&format=pdf" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
        <a href="generate.php?id=<?= $invoice['id'] ?>&format=xlsx" class="btn btn-sm btn-success">
            <i class="fa-solid fa-file-excel"></i> Excel
        </a>
        <a href="generate.php?id=<?= $invoice['id'] ?>&format=xml" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-file-code"></i> XML
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>

        </table>
    </div>

    <!-- Scripts (si usas JS como Bootstrap, jQuery, etc.) -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<div class="d-flex justify-content-start mt-4">
            <a href="/swift_invoice/" class="btn btn-secondary">← Volver al inicio</a>
        </div>
</body>
</html>