<!-- Información del Receptor -->
<div class="form-group">
     <label for="receiver_rfc">RFC del Receptor:</label>
     <input type="text" id="receiver_rfc" name="receiver_rfc" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="receiver_name">Nombre o Razón Social del Receptor:</label>
     <input type="text" id="receiver_name" name="receiver_name" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="receiver_address">Domicilio Fiscal del Receptor:</label>
     <input type="text" id="receiver_address" name="receiver_address" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="cfdi_use">Uso del CFDI:</label>
     <select id="cfdi_use" name="cfdi_use" class="form-control" required>
         <option value="G01">Adquisición de mercancias</option>
         <option value="G02">Devoluciones, descuentos o bonificaciones</option>
         <option value="I01">Servicios generales</option>
         <!-- Agregar más opciones según uso del CFDI -->
     </select>
 </div>
 
 <!-- Detalles de la Operación -->
 <div class="form-group">
     <label for="quantity">Cantidad:</label>
     <input type="number" id="quantity" name="quantity" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="unit">Unidad de Medida:</label>
     <input type="text" id="unit" name="unit" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="product">Descripción de los bienes o servicios:</label>
     <input type="text" id="product" name="product" class="form-control" required>
 </div>
 
 <!-- Precio Unitario -->
 <div class="form-group">
     <label for="price">Precio Unitario:</label>
     <input type="number" id="price" name="price" class="form-control" step="0.01" required>
 </div>
 
 <!-- Desglose de impuestos -->
 <div class="form-group">
     <label for="iva">IVA:</label>
     <input type="number" id="iva" name="iva" class="form-control" step="0.01" required>
 </div>
 
 <!-- Descuento -->
 <div class="form-group">
     <label for="discount">Descuento:</label>
     <input type="number" id="discount" name="discount" class="form-control" step="0.01">
 </div>
 
 <!-- Información Fiscal y Verificación -->
 <div class="form-group">
     <label for="folio_number">Folio Fiscal:</label>
     <input type="text" id="folio_number" name="folio_number" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="emission_date">Fecha y Hora de Expedición:</label>
     <input type="datetime-local" id="emission_date" name="emission_date" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="digital_stamp">Sello Digital del SAT:</label>
     <input type="text" id="digital_stamp" name="digital_stamp" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="original_chain">Cadena Original del Complemento de Certificación:</label>
     <input type="text" id="original_chain" name="original_chain" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="qr_code">Código QR:</label>
     <input type="text" id="qr_code" name="qr_code" class="form-control">
 </div>
 
 <div class="form-group">
     <label for="csd_serial_number">Número de Serie del CSD:</label>
     <input type="text" id="csd_serial_number" name="csd_serial_number" class="form-control">
 </div>
 
 <!-- Otros campos -->
 <div class="form-group">
     <label for="emission_place">Lugar de Expedición:</label>
     <input type="text" id="emission_place" name="emission_place" class="form-control" required>
 </div>
 
 <div class="form-group">
     <label for="payment_method">Forma de Pago:</label>
     <select id="payment_method" name="payment_method" class="form-control" required>
         <option value="Efectivo">Efectivo</option>
         <option value="Cheque">Cheque</option>
         <option value="Transferencia">Transferencia</option>
         <!-- Más opciones -->
     </select>
 </div>
 
 <div class="form-group">
     <label for="payment_conditions">Condiciones de Pago:</label>
     <input type="text" id="payment_conditions" name="payment_conditions" class="form-control">
 </div>