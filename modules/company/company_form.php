<?php
 // Conexión a la base de datos
 include_once('../../config/db.php');
 
 // Incluir encabezado
 include_once('../../includes/header.php');
 ?>
 
 <div class="container">
     <h2>Registrar Empresa</h2>
 
     <form action="company_save.php" method="POST">
         <div class="form-group">
             <label for="name">Nombre o Razón Social:</label>
             <input type="text" id="name" name="name" class="form-control" required>
         </div>
 
         <div class="form-group">
             <label for="rfc">RFC:</label>
             <input type="text" id="rfc" name="rfc" class="form-control" required>
         </div>
 
         <div class="form-group">
             <label for="address">Domicilio Fiscal:</label>
             <input type="text" id="address" name="address" class="form-control" required>
         </div>
 
         <div class="form-group">
             <label for="fiscal_regimen">Régimen Fiscal:</label>
             <select id="fiscal_regimen" name="fiscal_regimen" class="form-control" required>
                 <option value="Régimen General de Ley Personas Morales">Régimen General de Ley Personas Morales</option>
                 <option value="Régimen de Incorporación Fiscal">Régimen de Incorporación Fiscal</option>
                 <option value="Régimen de Sueldos y Salarios">Régimen de Sueldos y Salarios</option>
                 <!-- Agregar más opciones según el régimen fiscal -->
             </select>
         </div>
 
         <button type="submit" class="btn btn-success">Guardar Empresa</button>
     </form>
 </div>
 
 <?php
 // Incluir pie de página
 include_once('../../includes/footer.php');
 ?>