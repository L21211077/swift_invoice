<?php
 // Incluye la CONEXION A LA BASE DE DATOS
 include_once('../../config/db.php');
 
 // Opcional: incluir encabezado
 include_once('../../includes/header.php');
 
 // Consulta para obtener todas las empresas
 $query = "SELECT * FROM companies";
 $result = mysqli_query($conn, $query);
 ?>
 
 <div class="container">
     <h2>Empresas Registradas</h2>
 
     <?php if (isset($_GET['success'])): ?>
         <div class="alert alert-success">Empresa registrada correctamente.</div>
     <?php endif; ?>
 
     <a href="company_form.php" class="btn btn-primary mb-3">+ Nueva Empresa</a>
 
     <table class="table table-bordered">
         <thead>
             <tr>
                 <th>ID</th>
                 <th>Nombre</th>
                 <th>RFC</th>
                 <th>Dirección</th>
                 <th>Correo</th>
                 <th>Teléfono</th>
             </tr>
         </thead>
         <tbody>
             <?php while ($row = mysqli_fetch_assoc($result)): ?>
                 <tr>
                     <td><?= $row['id'] ?></td>
                     <td><?= htmlspecialchars($row['name']) ?></td>
                     <td><?= htmlspecialchars($row['rfc']) ?></td>
                     <td><?= htmlspecialchars($row['address']) ?></td>
                     <td><?= htmlspecialchars($row['email']) ?></td>
                     <td><?= htmlspecialchars($row['phone']) ?></td>
                 </tr>
             <?php endwhile; ?>
         </tbody>
     </table>
 </div>
 
 <?php
 // Opcional: incluir pie de página
 include_once('../../includes/footer.php');
 ?>