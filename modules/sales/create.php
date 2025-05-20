<?php
require_once '../../config/setup.php';
requireAuth();
require_once 'functions.php';

// 0) Limpia la sesión al entrar a crear una nueva venta
unset($_SESSION['sale_products']);

$page_title = "Nueva Venta - Swift Invoice";
require_once '../../includes/header.php';

$db            = new Database();
$conn          = $db->connect();
$clients       = getClients($conn);
$companies     = getCompanies($conn);
$products      = getProducts($conn);
$sale_products = $_SESSION['sale_products'] ?? [];
$totals        = calculateSaleTotals($sale_products);
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (isset($_SESSION['success_message'])) {
    echo '<script>
      Swal.fire({
        icon: "success",
        title: "' . addslashes($_SESSION['success_message']) . '",
        text: "Redirigiendo al listado de ventas...",
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.location.href = "/swift_invoice/modules/sales/";
      });
    </script>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<script>
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "' . addslashes($_SESSION['error_message']) . '",
        confirmButtonText: "OK",
        didOpen: () => { document.body.style.paddingRight = "0px"; }
      });
    </script>';
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $page_title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/swift_invoice/assets/css/sales.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
</head>
<body>

<div class="sales-container" style="max-width:820px;">
  <div class="card-header rounded-top-4">
    <h2 class="card-title mb-0 fw-bold text-center">Agregar Nueva Venta</h2>
  </div>
  <div class="card-body">
    <form id="sale-form" method="POST" action="process.php">
      <div class="row align-items-center">
        <div class="col-md-6">
          <!-- Tipo de cliente -->
          <div class="form-group">
            <label for="client_type" class="input-title">Tipo de Cliente:</label>
            <select id="client_type" name="client_type" class="form-control" required>
              <option value="">Seleccionar tipo</option>
              <option value="person">Persona Fisica</option>
              <option value="company">Persona Moral</option>
            </select>
          </div>
          <!-- Cliente o Empresa -->
          <div class="form-group">
            <label for="client_id" class="input-title">Cliente o Empresa:</label>
            <select id="client_id" name="client_id" class="form-control" required>
              <option value="">Seleccionar cliente</option>
            </select>
          </div>
          <!-- Fecha -->
          <div class="form-group">
            <label for="sale_date" class="input-title">Fecha:</label>
            <input type="date" id="sale_date" name="sale_date" class="form-control"
                   value="<?php echo date('Y-m-d'); ?>" required />
          </div>
        </div>
        <div class="col-md-6">
          <div class="summary-card p-3 border rounded">
            <h4>Resumen de Venta</h4>
            <div class="summary-row">
              <span>Subtotal:</span>
              <span id="subtotal">$<?php echo number_format($totals['subtotal'],2); ?></span>
            </div>
            <div class="summary-row">
              <span>Impuestos (<?php echo $totals['tax_percentage']; ?>%):</span>
              <span id="tax-amount">$<?php echo number_format($totals['tax_amount'],2); ?></span>
            </div>
            <div class="summary-row total">
              <span>Total:</span>
              <span id="total">$<?php echo number_format($totals['total'],2); ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Selección de productos/servicios -->
      <h3 class="text-start pt-3">Productos / Servicios</h3>
      <div class="row align-items-end mb-3">
        <div class="col-md-2">
          <label for="type_select" class="input-title">Tipo:</label>
          <select id="type_select" class="form-control">
            <option value="">Seleccionar...</option>
            <option value="Producto">Producto</option>
            <option value="Servicio">Servicio</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="product_id" class="input-title">Catálogo:</label>
          <select id="product_id" class="form-control">
            <option value="">Seleccionar...</option>
            <!-- Se llena desde JS -->
          </select>
        </div>
        <div class="col-md-2">
          <label for="price" class="input-title">Precio:</label>
          <input type="number" id="price" class="form-control" min="0" step="0.01" />
        </div>
        <div class="col-md-2">
          <label for="tax_rate" class="input-title">Impuesto (%):</label>
          <input type="number" id="tax_rate" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" />
        </div>
        <div class="col-md-1">
          <label for="quantity" class="input-title">Cantidad:</label>
          <input type="number" id="quantity" class="form-control" min="1" value="1"/>
        </div>
        <div class="col-md-2">
          <label>&nbsp;</label>
          <button type="button" id="add-product" class="btncss w-100">Agregar</button>
        </div>
      </div>

      <!-- Tabla de productos -->
      <div class="table-responsive mb-4">
        <table class="styled-table" id="product-table">
          <thead>
            <tr>
              <th>Producto/Servicio</th>
              <th>Precio Unitario</th>
              <th>Cantidad</th>
              <th>Impuesto</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sale_products as $i => $prod): ?>
              <tr data-index="<?php echo $i; ?>">
                <td><?php echo htmlspecialchars($prod['name']); ?></td>
                <td>$<?php echo number_format($prod['price'],2); ?></td>
                <td><?php echo $prod['quantity']; ?></td>
                <td><?php echo number_format($prod['tax_rate'],2); ?>%</td>
                <td>$<?php echo number_format($prod['price']*$prod['quantity'],2); ?></td>
                <td>
                  <button type="button" class="remove-product DeleteBtn">Eliminar</button>
                  <input type="hidden" name="products[<?php echo $i; ?>][id]"       value="<?php echo $prod['id']; ?>">
                  <input type="hidden" name="products[<?php echo $i; ?>][name]"     value="<?php echo htmlspecialchars($prod['name']); ?>">
                  <input type="hidden" name="products[<?php echo $i; ?>][price]"    value="<?php echo $prod['price']; ?>">
                  <input type="hidden" name="products[<?php echo $i; ?>][quantity]" value="<?php echo $prod['quantity']; ?>">
                  <input type="hidden" name="products[<?php echo $i; ?>][tax_rate]" value="<?php echo $prod['tax_rate']; ?>">
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center gap-5 mb-4">
        <a href="index.php" class="btnback">Cancelar</a>
        <button type="submit" class="btncss" disabled>Guardar Venta</button>
      </div>

      <input type="hidden" name="subtotal"       value="<?php echo $totals['subtotal']; ?>">
      <input type="hidden" name="tax_percentage" value="<?php echo $totals['tax_percentage']; ?>">
      <input type="hidden" name="tax_amount"     value="<?php echo $totals['tax_amount']; ?>">
      <input type="hidden" name="total"          value="<?php echo $totals['total']; ?>">
    </form>
  </div>
</div>

<!-- Combo clientes/empresas dinámico -->
<script>
  const clients   = <?php echo json_encode($clients); ?>;
  const companies = <?php echo json_encode($companies); ?>;
  const typeSelect   = document.getElementById('client_type');
  const clientSelect = document.getElementById('client_id');

  function rebuildClients() {
    clientSelect.innerHTML = '<option value="">Seleccionar cliente</option>';
    const list = typeSelect.value === 'company' ? companies : clients;
    list.forEach(item => {
      const opt = document.createElement('option');
      opt.value = item.id;
      opt.text  = item.name + (typeSelect.value === 'company' ? ' (Empresa)' : '');
      clientSelect.appendChild(opt);
    });
  }

  typeSelect.addEventListener('change', rebuildClients);
  document.addEventListener('DOMContentLoaded', rebuildClients);
</script>

<!-- PASO CLAVE: Exportar productos como array JS global -->
<script>
const allProducts = <?php echo json_encode($products); ?>;
console.log("allProducts:", allProducts); // Para depuración
</script>

<!-- Incluye tu JS de ventas -->
<script src="/swift_invoice/assets/js/sales.js"></script>

<?php require_once '../../includes/footer.php'; ?>
