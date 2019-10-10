<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SECCIÓN CONFIGURABLE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CONSIGNACION - Configuración
$PRO_CONSIGNACION_HABILITADO               = true;
$PRO_CONSIGNACION_MODO                     = 'PRODUCCION';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NO MODIFICAR A PARTIR DE ESTE PUNTO
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function consignacion_obtenerDatosCONSIGNACION()
{
    global $PRO_CONSIGNACION_HABILITADO;
    global $PRO_CONSIGNACION_MODO;
    
    $data                         = new stdClass();
    $data_detalles                = new stdClass();
    $data_detalles->habilitado    = $PRO_CONSIGNACION_HABILITADO;
    $data_detalles->modo          = $PRO_CONSIGNACION_MODO;
    $data->resultado = 'OK';
    $data->mensaje   = '¡Datos de CONSIGNACION disponibles!';
    $data->detalles  = $data_detalles;
    return $data;
}

function consignacion_generarPagoCONSIGNACION($carrito, $usuario, $escuela, $consignacion)
{
    // Handle the real store name
    $tienda = 'consignacion';
    
    // Prepare yoselfo...
    $data                     = new stdClass();
    $idcarrito                = $carrito->detalles->idcarrito;
    $carrito_comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $carrito_comprador_email  = $usuario->email;
    $carrito_concepto         = 'consignacion';
    $carrito_subtotal         = $carrito->detalles->subtotal_precio;
    $carrito_envio            = $carrito->detalles->total_envio;
    $carrito_total            = $carrito->detalles->total_precio;
    $carrito_moneda = 'MXN';
    
    $solicitud            = null;
    $solicitud_referencia = $idcarrito;
    $respuesta            = null;
    
    $respuesta_referencia       = $consignacion->idconsignacion;
    $respuesta_banco_nombre     = 'Contacto: ' . $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno . ' Teléfono: ' . $usuario->telefono . ' Correo Electrónico: ' . $usuario->email;
    $respuesta_banco_cuenta     = 'Escuela: ' . $escuela->nombre;
    $respuesta_banco_referencia = 'Dirección: ' . $escuela->calle . ($escuela->num_exterior ? " # Exterior " . $escuela->num_exterior : "") . ($escuela->num_interior ? " # Interior " . $escuela->num_interior : "");
    
    $fecha_hora_solicitud = date('Y-m-d G:i:s');
    $fecha_hora_respuesta = date('Y-m-d G:i:s');
    
    $pago_tienda          = $tienda;
    $pago_proveedor       = 'Links2Books';
    $pago_referencia      = 'Coordinador Email: ' . $usuario->nombre;
    $pago_estatus         = 0;
    $pago_estatus_leyenda = 'PENDIENTE';
    $pago_id              = $consignacion->idconsignacion;
    $pago_concepto        = $carrito_concepto;
    $pago_envio           = $carrito_envio;
    $pago_total           = $carrito_total;
    $pago_moneda          = $carrito_moneda;
    
    $pago_descripcion  = 'La consignación require un proceso de aprobación por parte de nuestro equipo.';
    $pago_paso_1       = $respuesta_banco_nombre;
    $pago_paso_2       = $respuesta_banco_cuenta;
    $pago_paso_3       = $respuesta_banco_referencia;
    $pago_comision     = 'Este tipo de pago no generá ningún tipo de comisión adicional.';
    $pago_expiracion   = 'Revisaremos el detalle de tu pedido y nos pondremos en contacto contigo a la brevedad.';
    $pago_confirmacion = 'Una vez que la consignación sea aprobada, recibirás un correo de confirmación y nos comunicaremos para afinar detalles.';
    
    $pago_nuevo    = new Pago();
    $pago_nuevo_id = $pago_nuevo->crearPago($idcarrito, $solicitud, $solicitud_referencia, $respuesta, $respuesta_referencia, $respuesta_banco_nombre, $respuesta_banco_cuenta, $respuesta_banco_referencia, $fecha_hora_solicitud, $fecha_hora_respuesta, $pago_tienda, $pago_proveedor, $pago_referencia, $pago_estatus, $pago_estatus_leyenda, $pago_id, $pago_concepto, $pago_envio, $pago_total, $pago_moneda, $pago_descripcion, $pago_paso_1, $pago_paso_2, $pago_paso_3, $pago_comision, $pago_expiracion, $pago_confirmacion);
    if ($pago_nuevo_id > 0)
    {
        $pago_nuevo_detalles         = new stdClass();
        $pago_nuevo_detalles->idpago = $pago_nuevo_id;
        $data->resultado             = 'OK';
        $data->mensaje               = '¡Registro de pago generado con estatus PENDIENTE!';
        $data->detalles              = $pago_nuevo_detalles;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error interno al crear el registro de pago!';
        $data->detalles  = null;
    }
    return $data;
}

?>