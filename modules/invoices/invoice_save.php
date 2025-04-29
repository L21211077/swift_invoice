<?php
 // Conexión a la base de datos
 include_once('../../config/db.php');
 
 // Verifica que los datos vienen por POST
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     // Recibe los datos del formulario
     $company_id = $_POST['company_id'];
     $receiver_rfc = $_POST['receiver_rfc'];
     $receiver_name = $_POST['receiver_name'];
     $receiver_address = $_POST['receiver_address'];
     $cfdi_use = $_POST['cfdi_use'];
     $product = $_POST['product'];
     $quantity = $_POST['quantity'];
     $unit = $_POST['unit'];
     $price = $_POST['price'];
     $iva = $_POST['iva'];
     $discount = $_POST['discount'];
     $folio_number = $_POST['folio_number'];
     $emission_date = $_POST['emission_date'];
     $digital_stamp = $_POST['digital_stamp'];
     $original_chain = $_POST['original_chain'];
     $qr_code = $_POST['qr_code'];
     $csd_serial_number = $_POST['csd_serial_number'];
     $emission_place = $_POST['emission_place'];
     $payment_method = $_POST['payment_method'];
     $payment_conditions = $_POST['payment_conditions'];
 
     // Calcula subtotal, IVA y total
     $subtotal = $quantity * $price;
     $iva_amount = ($subtotal * $iva) / 100;
     $total = $subtotal + $iva_amount - $discount;
 
     // Inserta en la tabla invoices
     $query = "INSERT INTO invoices (company_id, receiver_rfc, receiver_name, receiver_address, cfdi_use, product, quantity, unit, price, subtotal, iva, total, discount, folio_number, emission_date, digital_stamp, original_chain, qr_code, csd_serial_number, emission_place, payment_method, payment_conditions)
               VALUES ('$company_id', '$receiver_rfc', '$receiver_name', '$receiver_address', '$cfdi_use', '$product', '$quantity', '$unit', '$price', '$subtotal', '$iva_amount', '$total', '$discount', '$folio_number', '$emission_date', '$digital_stamp', '$original_chain', '$qr_code', '$csd_serial_number', '$emission_place', '$payment_method', '$payment_conditions')";
 
     if (mysqli_query($conn, $query)) {
         // Redirecciona al listado de facturas con mensaje de éxito
         header("Location: invoice_list.php?success=1");
         exit();
     } else {
         echo "Error al guardar la pre-factura: " . mysqli_error($conn);
     }
 } else {
     echo "Acceso no permitido.";
 }
 ?>