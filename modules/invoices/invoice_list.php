<?php
 // Conexión a la base de datos
 include_once('../../config/db.php');
 
 // Consulta para obtener todas las pre-facturas
 $query = "SELECT * FROM invoices";
 $result = mysqli_query($conn, $query);
 
 // Incluir encabezado
 include_once('../../includes/header.php');
 ?>
 
 <div class="container">
     <h2>Pre-facturas Registradas</h2>
 
     <?php if (isset($_GET['success'])): ?>
         <div class="alert alert-success">Pre-factura guardada correctamente.</div>
     <?php endif; ?>
 
     <a href="invoice_form.php" class="btn btn-primary mb-3">+ Nueva Pre-factura</a>
 
     <table class="table table-bordered">
         <thead>
             <tr>
                 <th>ID</th>
                 <th>Empresa</th>
                 <th>Fecha</th>
                 <th>Producto/Servicio</th>
                 <th>Cantidad</th>
                 <th>Precio Unitario</th>
                 <th>Subtotal</th>
                 <th>IVA</th>
                 <th>Total</th>
             </tr>
         </thead>
         <tbody>
             <?php while ($row = mysqli_fetch_assoc($result)): ?>
                 <tr>
                     <td><?= $row['id'] ?></td>
                     <td><?= htmlspecialchars($row['company_id']) ?></td>
                     <td><?= htmlspecialchars($row['invoice_date']) ?></td>
                     <td><?= htmlspecialchars($row['product']) ?></td>
                     <td><?= htmlspecialchars($row['quantity']) ?></td>
                     <td><?= htmlspecialchars($row['price']) ?></td>
                     <td><?= htmlspecialchars($row['subtotal']) ?></td>
                     <td><?= htmlspecialchars($row['iva']) ?></td>
                     <td><?= htmlspecialchars($row['total']) ?></td>
                 </tr>
             <?php endwhile; ?>
         </tbody>
     </table>
 </div>
 
 <?php
 // Incluir pie de página
 include_once('../../includes/footer.php');
 ?>