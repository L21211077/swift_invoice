<?php
 // Incluye la CONEXION A LA BASE DE DATOS
 include_once('../../config/db.php');
 
 // Verifica que los datos vienen por POST
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     // Recibe los datos del formulario
     $name = $_POST['company_name'];
     $rfc = $_POST['company_rfc'];
     $address = $_POST['company_address'];
     $email = $_POST['company_email'];
     $phone = $_POST['company_phone'];
 
     // Prepara e inserta los datos en la base de datos
     $query = "INSERT INTO companies (name, rfc, address, email, phone) 
               VALUES ('$name', '$rfc', '$address', '$email', '$phone')";
 
     if (mysqli_query($conn, $query)) {
         // Redirecciona de vuelta a la lista de empresas o muestra mensaje de éxito
         header("Location: company_list.php?success=1");
         exit();
     } else {
         echo "Error al guardar la empresa: " . mysqli_error($conn);
     }
 } else {
     echo "Acceso no permitido.";
 }
 ?>