<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/vendor/conekta-php/lib/Conekta.php';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SECCIÓN CONFIGURABLE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CONEKTA - API keys para pagos con tarjetas bancarias
$PRO_CONEKTA_PRODUCCION_LLAVE_PUBLICA = 'key_fKNPGDrkCbukks9Kqao33Qw';
$PRO_CONEKTA_PRODUCCION_LLAVE_PRIVADA = 'key_hqN4rMWsfVSiZB9pad8dng';
$PRO_CONEKTA_PRUEBAS_LLAVE_PUBLICA    = 'key_DknJ1WzrRfLgd9LJWVBXTEg';
$PRO_CONEKTA_PRUEBAS_LLAVE_PRIVADA    = 'key_Aq4ygzstyyX1FwwxYsLidA';
$PRO_CONEKTA_HABILITADO               = true;
$PRO_CONEKTA_MODO                     = 'PRODUCCION';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NO MODIFICAR A PARTIR DE ESTE PUNTO
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CONEKTA - API keys a usar según el modo seleccionado
$PRO_CONEKTA_LLAVE_PUBLICA = ($PRO_CONEKTA_MODO == 'PRODUCCION' ? $PRO_CONEKTA_PRODUCCION_LLAVE_PUBLICA : $PRO_CONEKTA_PRUEBAS_LLAVE_PUBLICA);
$PRO_CONEKTA_LLAVE_PRIVADA = ($PRO_CONEKTA_MODO == 'PRODUCCION' ? $PRO_CONEKTA_PRODUCCION_LLAVE_PRIVADA : $PRO_CONEKTA_PRUEBAS_LLAVE_PRIVADA);

// CONEKTA - Nombres y emails a usar para el modo de pruebas
$PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE = '';
$PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_EMAIL  = '';
$PRO_CONEKTA_MODO_PRUEBAS_CASO = '';
if ($PRO_CONEKTA_MODO == 'PRUEBAS')
{
    $nombres_random                            = array(
        'Alumno 1 X',
        'Alumno 2 X',
        'Alumno 3 X',
        'Alumno 4 X',
        'Alumno 5 X',
        'Alumno 6 X',
        'Alumno 7 X',
        'Alumno 8 X',
        'Alumno 9 X',
        'Alumno 10 X',
        'Alumno 11 X',
        'Alumno 12 X',
        'Alumno 13 X',
        'Alumno 14 X',
        'Alumno 15 X',
        'Alumno 16 X',
        'Alumno 17 X',
        'Alumno 18 X',
        'Alumno 19 X',
        'Alumno 20 X'
    );
    //$nombres_random = array('Razor Tsuchinoko', 'Rumble Tengu', 'Dizzy Capybara', 'Bolt Chicken', 'Crawling Squirrel', 'Hulking Spider', 'Running Leopard', 'Silver Mammoth', 'Piranha Eater', 'Small Armadillo');
    $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE = $nombres_random[array_rand($nombres_random)];
    $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_EMAIL  = strtolower(str_replace(' ', '_', $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE)) . '@email.com';
    $nombres_tarjetas                            = array(
        'VISA_1',
        'VISA_2',
        'MASTERCARD_1',
        'MASTERCARD_2',
        'AMERICANEXPRESS_1',
        'AMERICANEXPRESS_2',
        'DECLINADA',
        'SIN_FONDOS',
        'MSI_ERROR'
    );
    $PRO_CONEKTA_MODO_PRUEBAS_CASO = $nombres_tarjetas[array_rand($nombres_tarjetas)];
}

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta VISA 1
$PRO_CONEKTA_PRUEBAS_VISA_1_TARJETA = '4242424242424242';
$PRO_CONEKTA_PRUEBAS_VISA_1_TOKEN   = 'tok_test_visa_4242';

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta VISA 2
$PRO_CONEKTA_PRUEBAS_VISA_2_TARJETA = '4012888888881881';
$PRO_CONEKTA_PRUEBAS_VISA_2_TOKEN   = 'tok_test_visa_1881';

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta MASTERCARD 1
$PRO_CONEKTA_PRUEBAS_MASTERCARD_1_TARJETA = '5555555555554444';
$PRO_CONEKTA_PRUEBAS_MASTERCARD_1_TOKEN   = 'tok_test_mastercard_4444';

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta MASTERCARD 2
$PRO_CONEKTA_PRUEBAS_MASTERCARD_2_TARJETA = '5105105105105100';
$PRO_CONEKTA_PRUEBAS_MASTERCARD_2_TOKEN   = 'tok_test_mastercard_5100';

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta AMERICAN EXPRESS 1
$PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_1_TARJETA = '378282246310005';
$PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_1_TOKEN   = 'tok_test_amex_0005';

// CONEKTA - Claves de prueba para el modo PRUEBAS con tarjeta AMERICAN EXPRESS 2
$PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_2_TARJETA = '371449635398431';
$PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_2_TOKEN   = 'tok_test_amex_8431';

// CONEKTA - Tarjeta de prueba con error específico - "La tarjeta ingresada ha sido declinada. Por favor intenta con otro método de pago."
$PRO_CONEKTA_PRUEBAS_ERROR_DECLINADA_TARJETA = '4000000000000002';
$PRO_CONEKTA_PRUEBAS_ERROR_DECLINADA_TOKEN   = 'tok_test_card_declined';

// CONEKTA - Tarjeta de prueba con error específico - "Esta tarjeta no tiene suficientes fondos para completar la compra."
$PRO_CONEKTA_PRUEBAS_ERROR_SIN_FONDOS_TARJETA = '4000000000000127';
$PRO_CONEKTA_PRUEBAS_ERROR_SIN_FONDOS_TOKEN   = 'tok_test_insufficient_funds';

// CONEKTA - Tarjeta de prueba con error específico - "Simulaciones para Meses Sin Intereses."
$PRO_CONEKTA_PRUEBAS_ERROR_MSI_TARJETA = '4111111111111111';
$PRO_CONEKTA_PRUEBAS_ERROR_MSI_TOKEN   = 'tok_test_msi_error';

// CONEKTA - ¿Que casos de prueba se usarán?
$PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = '';
$PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = '';
if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'VISA_1')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_VISA_1_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_VISA_1_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'VISA_2')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_VISA_2_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_VISA_2_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'MASTERCARD_1')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_MASTERCARD_1_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_MASTERCARD_1_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'MASTERCARD_2')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_MASTERCARD_2_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_MASTERCARD_2_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'AMERICANEXPRESS_1')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_1_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_1_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'AMERICANEXPRESS_2')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_2_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_AMERICANEXPRESS_2_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'DECLINADA')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_ERROR_DECLINADA_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_ERROR_DECLINADA_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'SIN_FONDOS')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_ERROR_SIN_FONDOS_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_ERROR_SIN_FONDOS_TOKEN;
}
else if ($PRO_CONEKTA_MODO_PRUEBAS_CASO == 'MSI_ERROR')
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_ERROR_MSI_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_ERROR_MSI_TOKEN;
}
else
{
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA = $PRO_CONEKTA_PRUEBAS_VISA_1_TARJETA;
    $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN   = $PRO_CONEKTA_PRUEBAS_VISA_1_TOKEN;
}

function conekta_obtenerDatosCONEKTA()
{
    global $PRO_CONEKTA_HABILITADO;
    global $PRO_CONEKTA_MODO;
    global $PRO_CONEKTA_LLAVE_PUBLICA;
    global $PRO_CONEKTA_LLAVE_PRIVADA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN;
    
    $data                         = new stdClass();
    $data_detalles                = new stdClass();
    $data_detalles->habilitado    = $PRO_CONEKTA_HABILITADO;
    $data_detalles->modo          = $PRO_CONEKTA_MODO;
    $data_detalles->llave_publica = $PRO_CONEKTA_LLAVE_PUBLICA;
    if ($PRO_CONEKTA_MODO == 'PRUEBAS')
    {
        $data_detalles->modo_pruebas_tarjeta        = $PRO_CONEKTA_MODO_PRUEBAS_CASO;
        $data_detalles->modo_pruebas_tarjeta_numero = $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA;
        $data_detalles->modo_pruebas_tarjeta_token  = $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN;
    }
    $data->resultado = 'OK';
    $data->mensaje   = '¡Datos de CONEKTA disponibles!';
    $data->detalles  = $data_detalles;
    return $data;
}

function conekta_generarPagoTarjeta($carrito, $usuario, $escuela, $token_id)
{
    global $PRO_CONEKTA_MODO;
    global $PRO_CONEKTA_LLAVE_PUBLICA;
    global $PRO_CONEKTA_LLAVE_PRIVADA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_EMAIL;
    
    // Handle the real store name
    $tienda = 'Tarjeta';
    
    // Prepare yoselfo...
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data                     = new stdClass();
    $idcarrito                = $carrito->detalles->idcarrito;
    $carrito_comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $carrito_comprador_email  = $usuario->email;
    $carrito_concepto         = $carrito->detalles->detalles[0]->nombre;
    $carrito_subtotal            = $carrito->detalles->subtotal_precio;
    $carrito_envio            = $carrito->detalles->total_envio;
    $carrito_total            = $carrito->detalles->total_precio;
    $carrito_moneda = 'MXN';
    
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data = new stdClass();
    $order = null;
    
    try
    {
        $order = \Conekta\Order::create(array(
            "line_items" => array(
                array(
                    "name" => $carrito_concepto,
                    "unit_price" => $carrito_subtotal * 100,
                    "quantity" => 1
                ) //first line_item
            ), //line_items
            "shipping_lines" => array(
                array(
                    "amount" => $carrito_envio * 100,
                    "carrier" => "Links2Books"
                )
            ), //shipping_lines - physical goods only
            "currency" => "MXN",
            "customer_info" => array(
                "name" => $carrito_comprador_nombre,
                "email" => $carrito_comprador_email,
                "phone" => "0000000000"
            ), //customer_info
            "shipping_contact" => array(
                "address" => array(
                    "street1" => $escuela->calle . ($escuela->num_exterior ? " # Exterior " . $escuela->num_exterior : "") . ($escuela->num_interior ? " # Interior " . $escuela->num_interior : ""),
                    "postal_code" => $escuela->codigo_postal,
                    "country" => "MX"
                ) //address
            ), //shipping_contact - required only for physical goods
            "metadata" => array("reference" => "Links2Books", "more_info" => "Compra en Links2Books"),
            "charges" => array(
                array(
                    "payment_method" => array(
                        "type" => "card",
                        "token_id" => $token_id
                    ) //payment_method
                ) //first charge
            ) //charges
        ) //order
    );
    }
    catch (\Conekta\ParameterValidationError $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    catch (\Conekta\Handler $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    
    $solicitud            = json_encode(addslashes($order));
    $solicitud_referencia = $idcarrito;
    $respuesta            = json_encode(addslashes($order));
    
    $respuesta_referencia       = $order->charges->{0}->payment_method->auth_code;
    $respuesta_banco_nombre     = $tienda;
    $respuesta_banco_cuenta     = $order->charges->{0}->payment_method->brand;
    $respuesta_banco_referencia = $order->charges->{0}->payment_method->type;
    
    $respuesta_banco_cuenta_leyenda = '';
    if ($respuesta_banco_cuenta == 'visa')
    {
        $respuesta_banco_cuenta_leyenda = 'VISA';
    }
    if ($respuesta_banco_cuenta == 'mastercard' || $respuesta_banco_cuenta == 'mc' )
    {
        $respuesta_banco_cuenta_leyenda = 'MASTERCARD';
    }
    if ($respuesta_banco_cuenta == 'american_express')
    {
        $respuesta_banco_cuenta_leyenda = 'AMERICAN_EXPRESS';
    }
    
    $respuesta_banco_referencia_leyenda = '';
    if ($respuesta_banco_referencia == 'debit')
    {
        $respuesta_banco_referencia_leyenda = 'DÉBITO';
    }
    if ($respuesta_banco_referencia == 'credit')
    {
        $respuesta_banco_referencia_leyenda = 'CRÉDITO';
    }
    
    $respuesta_nombre          = $order->charges->{0}->payment_method->name;
    $respuesta_digitos         = $order->charges->{0}->payment_method->last4;
    $respuesta_fecha           = date('Y-m-d G:i:s', $order->charges->{0}->created_at);
    
    $fecha_hora_solicitud = date('Y-m-d G:i:s');
    $fecha_hora_respuesta = date('Y-m-d G:i:s');
    
    $pago_tienda          = $tienda;
    $pago_proveedor       = 'CONEKTA';
    $pago_referencia      = $order->charges->{0}->payment_method->auth_code;
    $pago_estatus         = 1;
    $pago_estatus_leyenda = 'PAGADO';
    $pago_id              = $order->id;
    $pago_concepto        = $carrito_concepto;
    $pago_envio           = $carrito_envio;
    $pago_total           = $carrito_total;
    $pago_moneda          = $carrito_moneda;
    
    $pago_descripcion  = 'Pago realizado a nombre de ' . $respuesta_nombre . ' con Tarjeta Bancaria, autorización: ' . $respuesta_referencia;
    $pago_paso_1       = 'Forma de pago: ' . $respuesta_banco_cuenta_leyenda;
    $pago_paso_2       = 'Tipo: ' . $respuesta_banco_referencia_leyenda;
    $pago_paso_3       = 'Últimos 4 dígitos de la tarjeta: ' . $respuesta_digitos;
    $pago_comision     = 'Este tipo de pago no genera comisión.';
    $pago_expiracion   = 'Fecha y hora del pago: ' . $respuesta_fecha;
    $pago_confirmacion = 'En breve recibirás una confirmación de tu pago en tu correo electrónico.';
    
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

function conekta_generarPagoOXXO($carrito, $usuario, $escuela)
{
    global $PRO_CONEKTA_MODO;
    global $PRO_CONEKTA_LLAVE_PUBLICA;
    global $PRO_CONEKTA_LLAVE_PRIVADA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_EMAIL;
    
    // Handle the real store name
    $tienda = 'oxxo_cash';
    
    // Prepare yoselfo...
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data                     = new stdClass();
    $idcarrito                = $carrito->detalles->idcarrito;
    $carrito_comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $carrito_comprador_email  = $usuario->email;
    $carrito_concepto         = $carrito->detalles->detalles[0]->nombre;
    $carrito_subtotal            = $carrito->detalles->subtotal_precio;
    $carrito_envio            = $carrito->detalles->total_envio;
    $carrito_total            = $carrito->detalles->total_precio;
    $carrito_moneda = 'MXN';
    
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data = new stdClass();
    $order = null;
    
    try
    {
        $order = \Conekta\Order::create(array(
            "line_items" => array(
                array(
                    "name" => $carrito_concepto,
                    "unit_price" => $carrito_subtotal * 100,
                    "quantity" => 1
                ) //first line_item
            ), //line_items
            "shipping_lines" => array(
                array(
                    "amount" => $carrito_envio * 100,
                    "carrier" => "Links2Books"
                )
            ), //shipping_lines - physical goods only
            "currency" => "MXN",
            "customer_info" => array(
                "name" => $carrito_comprador_nombre,
                "email" => $carrito_comprador_email,
                "phone" => "0000000000"
            ), //customer_info
            "shipping_contact" => array(
                "address" => array(
                    "street1" => $escuela->calle . ($escuela->num_exterior ? " # Exterior " . $escuela->num_exterior : "") . ($escuela->num_interior ? " # Interior " . $escuela->num_interior : ""),
                    "postal_code" => $escuela->codigo_postal,
                    "country" => "MX"
                ) //address
            ), //shipping_contact - required only for physical goods
            "charges" => array(
                array(
                    "payment_method" => array(
                        "type" => "oxxo_cash"
                    ) //payment_method
                ) //first charge
            ) //charges
        ) //order
    );
    }
    catch (\Conekta\ParameterValidationError $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    catch (\Conekta\Handler $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    
    $solicitud            = json_encode(addslashes($order));
    $solicitud_referencia = $idcarrito;
    $respuesta            = json_encode(addslashes($order));
    
    $respuesta_referencia       = $order->charges->{0}->payment_method->reference;
    $respuesta_banco_nombre     = $tienda;
    $respuesta_banco_cuenta     = $order->charges->{0}->payment_method->reference;
    $respuesta_banco_referencia = $order->charges->{0}->payment_method->reference;
    
    $fecha_hora_solicitud = date('Y-m-d G:i:s');
    $fecha_hora_respuesta = date('Y-m-d G:i:s');
    
    $pago_tienda          = $tienda;
    $pago_proveedor       = 'CONEKTA';
    $pago_referencia      = $order->charges->{0}->payment_method->reference;
    $pago_estatus         = 0;
    $pago_estatus_leyenda = 'PENDIENTE';
    $pago_id              = $order->id;
    $pago_concepto        = $carrito_concepto;
    $pago_envio           = $carrito_envio;
    $pago_total           = $carrito_total;
    $pago_moneda          = $carrito_moneda;
    
    $pago_descripcion  = 'Acude a la tienda OXXO más cercana.';
    $pago_paso_1       = 'Indica en caja que quieres realizar un pago de OXXOPay.';
    $pago_paso_2       = 'Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.';
    $pago_paso_3       = 'Realiza el pago correspondiente con dinero en efectivo.';
    $pago_comision     = 'El cajero te cobrará una comisión adicional de $12.00.';
    $pago_expiracion   = 'Al confirmar tu pago, el cajero te entregará un comprobante impreso. En el podrás verificar que se haya realizado correctamente. Conserva este comprobante de pago. Tienes hasta un mes para realizar tu pago, sin embargo, recomendamos que lo realices lo más pronto posible, dentro de 48 horas.';
    $pago_confirmacion = 'Al completar estos pasos recibirás un correo confirmando tu pago.';
    
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

function conekta_generarPagoSPEI($carrito, $usuario, $escuela)
{
    global $PRO_CONEKTA_MODO;
    global $PRO_CONEKTA_LLAVE_PUBLICA;
    global $PRO_CONEKTA_LLAVE_PRIVADA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TARJETA;
    global $PRO_CONEKTA_MODO_PRUEBAS_CASO_TOKEN;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_NOMBRE;
    global $PRO_CONEKTA_MODO_PRUEBAS_COMPRADOR_EMAIL;
    
    // Handle the real store name
    $tienda = 'spei';
    
    // Prepare yoselfo...
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data                     = new stdClass();
    $idcarrito                = $carrito->detalles->idcarrito;
    $carrito_comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $carrito_comprador_email  = $usuario->email;
    $carrito_concepto         = $carrito->detalles->detalles[0]->nombre;
    $carrito_subtotal            = $carrito->detalles->subtotal_precio;
    $carrito_envio            = $carrito->detalles->total_envio;
    $carrito_total            = $carrito->detalles->total_precio;
    $carrito_moneda = 'MXN';
    
    \Conekta\Conekta::setApiKey($PRO_CONEKTA_LLAVE_PRIVADA);
    \Conekta\Conekta::setApiVersion('2.0.0');
    $data = new stdClass();
    $order = null;
    
    try
    {
        $order = \Conekta\Order::create(array(
            "line_items" => array(
                array(
                    "name" => $carrito_concepto,
                    "unit_price" => $carrito_subtotal * 100,
                    "quantity" => 1
                ) //first line_item
            ), //line_items
            "shipping_lines" => array(
                array(
                    "amount" => $carrito_envio * 100,
                    "carrier" => "Links2Books"
                )
            ), //shipping_lines - physical goods only
            "currency" => "MXN",
            "customer_info" => array(
                "name" => $carrito_comprador_nombre,
                "email" => $carrito_comprador_email,
                "phone" => "0000000000"
            ), //customer_info
            "shipping_contact" => array(
                "address" => array(
                    "street1" => $escuela->calle . ($escuela->num_exterior ? " # Exterior " . $escuela->num_exterior : "") . ($escuela->num_interior ? " # Interior " . $escuela->num_interior : ""),
                    "postal_code" => $escuela->codigo_postal,
                    "country" => "MX"
                ) //address
            ), //shipping_contact - required only for physical goods
            "charges" => array(
                array(
                    "payment_method" => array(
                        "type" => "spei"
                    ) //payment_method
                ) //first charge
            ) //charges
        ) //order
    );
    }
    catch (\Conekta\ParameterValidationError $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    catch (\Conekta\Handler $error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error->getMessage();
        $data->detalles  = null;
        return $data;
    }
    
    $solicitud            = json_encode(addslashes($order));
    $solicitud_referencia = $idcarrito;
    $respuesta            = json_encode(addslashes($order));
    
    $respuesta_referencia       = $order->charges->{0}->payment_method->receiving_account_number;
    $respuesta_banco_nombre     = $order->charges->{0}->payment_method->receiving_account_bank;
    $respuesta_banco_cuenta     = $order->charges->{0}->payment_method->receiving_account_number;
    $respuesta_banco_referencia = $order->charges->{0}->payment_method->receiving_account_number;
    
    $fecha_hora_solicitud = date('Y-m-d G:i:s');
    $fecha_hora_respuesta = date('Y-m-d G:i:s');
    
    $pago_tienda          = $tienda;
    $pago_proveedor       = 'CONEKTA';
    $pago_referencia      = $order->charges->{0}->payment_method->receiving_account_number;
    $pago_estatus         = 0;
    $pago_estatus_leyenda = 'PENDIENTE';
    $pago_id              = $order->id;
    $pago_concepto        = $carrito_concepto;
    $pago_envio           = $carrito_envio;
    $pago_total           = $carrito_total;
    $pago_moneda          = $carrito_moneda;
    
    $pago_descripcion  = 'Inicia sesión en el portal de tu banco o en la aplicación del mismo en tu teléfono móvil.';
    $pago_paso_1       = 'Busca la opción de pago/transferencia por SPEI.';
    $pago_paso_2       = 'Introduce la CLABE proporcionada y selecciona el banco STP. En beneficiario y concepto, introduce Link2Books.';
    $pago_paso_3       = 'Realiza el pago/transferencia por la cantidad EXACTA, de lo contrario la operación será RECHAZADA.';
    $pago_comision     = 'Este tipo de pago no generá ningún tipo de comisión adicional.';
    $pago_expiracion   = 'Tienes hasta dos mes para realizar tu pago, sin embargo, recomendamos que lo realices lo más pronto posible, dentro de 48 horas.';
    $pago_confirmacion = 'Una vez que el pago haya sido procesado, el portal de tu banco o aplicación movíl te entregará un comprobante digital, conservalo o tóma una captura de la pantalla ya que está será tu comprobante de pago y comprueba que se haya realizado correctamente. En algunas ocasiones el pago puede verse reflejado hasta 48 horas después. Una vez que el pago se haya procesado correctamente, recibirás un correo confirmando tu pago.';
    
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