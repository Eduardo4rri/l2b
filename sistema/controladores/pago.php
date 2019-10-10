<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Pago.php';

// obtenerReferenciaPago($idpago)
// Descripción:
// Obtiene los datos de la referencia de un pago
// Notas:
// N/A
function obtenerReferenciaPago($idpago)
{
    $pago = new Pago();
    $data  = new stdClass();
    $rspta = $pago->obtenerReferenciaPago($idpago);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Datos de la referencia del pago disponibles!';
        $data->detalles  = $rspta;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos de la referencia del pago no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

?>