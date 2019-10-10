<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Pago.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Webhook.php';
http_response_code(200);
$body = @file_get_contents('php://input');
$data = json_decode($body);
$resultado   = new stdClass();

function enviarNotificacion($venta_idventa, $referencia_tipo)
{
    $notif = new stdClass();
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);
    curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_SALES);
    curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
    curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['saleID' => $venta_idventa, 'type' => $referencia_tipo]);
    curl_exec($curl);
    if (curl_error($curl))
    {
        $error_msg = curl_error($curl);
    }
    if (!isset($error_msg))
    {
        $notif->resultado = 'OK';
        $notif->mensaje   = '¡Notificación de pago enviada!';
    }
    else
    {
        $notif->resultado = 'ADVERTENCIA';
        $notif->mensaje   = $error_msg;
    }
    curl_close($curl);
    return $notif;
}

if ($data->type == 'order.paid' || $data->type == 'charge.paid')
{
    // Extraer datos necesarios del JSON enviado por CONEKTA
    $wh_id = $data->data->object->id;
    $wh_tipo = $data->data->object->charges->data[0]->payment_method->type;
    $wh_estatus = $data->data->object->charges->data[0]->status;
    
    // ¿Que tipo de pago es?
    $wh_referencia = '';
    $formato_confirmacion = '';
    if ($wh_tipo == 'oxxo')
    {
        $wh_referencia = $data->data->object->charges->data[0]->payment_method->reference;
        $referencia_tipo = 'Confirmacion Pago OXXO';
    }
    else if ($wh_tipo == 'spei')
    {
        $wh_referencia = $data->data->object->charges->data[0]->payment_method->clabe;
        $referencia_tipo = 'Confirmacion Pago SPEI';
    }
    else if ($wh_tipo == 'debit' || $wh_tipo == 'credit')
    {
        $wh_referencia = $data->data->object->charges->data[0]->payment_method->auth_code;
        $referencia_tipo = 'Confirmacion Pago TARJETA BANCARIA';
    }
    
    // Buscar el registro de pago correspondiente
    $pago_obj = new Pago();
    $pago = $pago_obj->obtenerReferenciaPagoPorIDOrdenYReferencia($wh_id, $wh_referencia);
    
    // ¿No se encontró el pago?
    if (!$pago)
    {
        $resultado->resultado = 'ERROR';
        $resultado->mensaje   = '¡No se encontró el registro del pago!';
        $resultado->notificacion  = null;
        exit(json_encode($resultado));
    }
    
    // Obtener los datos del pago
    $pago_idpago = $pago->idpago;
    $pago_estatus = $pago->pago_estatus;
    
    // Revisar el estatus del pago
    if ($wh_tipo == 'oxxo' || $wh_tipo == 'spei')
    {
        // ¿El pago ya esta pagado?
        if ($pago_estatus == 1)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro del pago ya se encuentra PAGADO!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
        
        // ¿El pago ya esta expirado?
        else if ($pago_estatus == 2)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro del pago ya se encuentra EXPIRADO!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
    }
    else if ($wh_tipo == 'debit' || $wh_tipo == 'credit')
    {
        // Este tipo de pago por tarjeta de débito o de crédito ya debe de estar pagado
    }
    
    // Buscar el registro de la venta correspondiente
    $venta_obj = new Venta();
    $venta = $venta_obj->obtenerVentaPorIDPago($pago_idpago);
    
    // ¿No se encontró la venta?
    if (!$venta)
    {
        $resultado->resultado = 'ERROR';
        $resultado->mensaje   = '¡No se encontró el registro de la venta!';
        $resultado->notificacion  = null;
        exit(json_encode($resultado));
    }
    
    // Obtener los datos de la venta
    $venta_idventa = $venta->idventa;
    $venta_estatus = $venta->estatus_pago;
    
    // Revisar el estatus de la venta
    if ($wh_tipo == 'oxxo' || $wh_tipo == 'spei')
    {
        // ¿La venta ya esta pagada?
        if ($venta_estatus == 1)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro de la venta ya se encuentra PAGADA!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
        
        // ¿La venta ya esta expirada?
        else if ($venta_estatus == 2)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro de la venta ya se encuentra EXPIRADA!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
    }
    else if ($wh_tipo == 'debit' || $wh_tipo == 'credit')
    {
        // Este tipo de venta por tarjeta de débito o de crédito ya debe de estar pagada
    }
    
    // Actualizar el estatus del pago y de la venta
    if ($wh_tipo == 'oxxo' || $wh_tipo == 'spei')
    {
        // Actualizar el estatus del pago
        $pago_fecha_hora_aprobacion = date('Y-m-d G:i:s');
        $pago_fecha_hora_rechazo = '';
        $pago_fecha_hora_expiracion = '';
        $pago_act = $pago_obj->actualizarEstatusPago($pago_idpago, 1, 'PAGADO', $pago_fecha_hora_aprobacion, $pago_fecha_hora_rechazo, $pago_fecha_hora_expiracion);
        if (!$pago_act)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro del pago no se pudo actualizar a PAGADO!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
        
        // Actualizar el estatus de la venta
        $venta_act = $venta_obj->actualizarEstatusVenta($venta_idventa, 1, 'PAGADA', $pago_fecha_hora_aprobacion);
        if (!$venta_act)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro de la venta no se pudo actualizar a PAGADA!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
    }
    else if ($wh_tipo == 'debit' || $wh_tipo == 'credit')
    {
        // Este tipo de pago por tarjeta de débito o de crédito ya debe de estar pagado
        $pago_fecha_hora_aprobacion = date('Y-m-d G:i:s');
        
        // Actualizar el estatus de la venta
        $venta_act = $venta_obj->actualizarEstatusVenta($venta_idventa, 1, 'PAGADA', $pago_fecha_hora_aprobacion);
        if (!$venta_act)
        {
            $resultado->resultado = 'ERROR';
            $resultado->mensaje   = '¡El registro de la venta no se pudo actualizar a PAGADA!';
            $resultado->notificacion  = null;
            exit(json_encode($resultado));
        }
    }
    
    $notif = enviarNotificacion($venta_idventa, $referencia_tipo);
    $wh = new Webhook();
    $data_cadena = $body;
    $data_cadena_limpia = addslashes($data_cadena);
    $wh->crearRegistro($venta_idventa, $pago_idpago, $data_cadena_limpia, $wh_id, $wh_referencia, $wh_estatus);
    $resultado->resultado = 'OK';
    $resultado->mensaje   = '¡Webhook recibido y procesado!';
    $resultado->notificacion  = $notif;
    exit(json_encode($resultado));
    
}
else
{
    $resultado->resultado = 'ERROR';
    $resultado->mensaje   = '¡Tipo de evento no soportado!';
    $resultado->notificacion  = null;
    exit(json_encode($resultado));
}

?>